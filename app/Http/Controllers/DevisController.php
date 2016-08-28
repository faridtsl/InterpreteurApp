<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Devi;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\DevisEtatTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
use App\Tools\InterpreteurTools;
use App\Tools\ServiceTools;
use App\Trace;
use App\User;
use Illuminate\Http\Request;
use App\Tools\MailTools;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class DevisController extends Controller{

    public function show(Request $request){
        $demande = Demande::find($request['id']);
        //$interpreteurs = InterpreteurTools::getAllInterpreteurs();
        return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>[]]);
    }

    public function store(Request $request){
        $connectedUser = Auth::user();
        $demande = Demande::find($request['demande_id']);
        try {
            DB::beginTransaction();
            $devis = DevisTools::addDevis($request,$connectedUser);
            $interps = $request['idInterp'];
            $sends = $request['sendMail'];
            if($interps==null) return view('devis.devisAdd',['demande'=>$demande])->withErrors(['Vous devez choisir au moins un inteprete']);
            $attachs = [];
            foreach($interps as $key => $value){
                $interp = InterpreteurTools::getInterpreteur($value);
                if($sends[$key]=='cv' && $interp->cv != 'NULL'){
                    array_push($attachs,storage_path().'/cv/'.$interp->cv);
                }
                if($sends[$key]=='cv_anonyme'  && $interp->cv_anonyme != 'NULL'){
                    array_push($attachs,storage_path().'/cv_anonyme/'.$interp->cv_anonyme);
                }
                $interp->devis()->attach($devis);
            }
            DevisTools::sendDevisMail($devis,$attachs);
            DB::commit();
            return view('devis.devisAdd',['demande'=>$demande,'message'=>'Devis ajouté avec success']);
        }catch(\Exception $e){
            DB::rollback();
            $trace = new Trace();
            $trace->operation = "Creation";
            $trace->type = 'Devis';
            $trace->resultat = false;
            $trace->user()->associate($connectedUser);
            $trace->save();
            DB::commit();
        }
        $errors = ['Une erreur s\'est survenu veuillez reverifier vos données'];
        return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs])->withErrors($errors);
    }

    public function showDevis(Request $request){
        $devis = Devi::all();
        if($request->isMethod('post')){
            $devis = DevisTools::searchByDates($request);
        }
        return view('devis.devisShow',['devis'=>$devis]);
    }

    public function resendDevis(Request $request){
        $devis = Devi::find($request['id']);
        DevisTools::sendDevisMail($devis,[]);
    }

    public function viewDevis(Request $request){
        $devis = DevisTools::getDevisById($request['id']);
        $demande = DemandeTools::getDemande($devis->demande_id);
        $client = ClientTools::getClient($demande->client_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $services = ServiceTools::getServices($devis->id);
        if($devis->trashed()) $services = ServiceTools::getServicesArchive($devis->id);
        return view('emails.devis',['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis]);
    }

    public function archiveDevis(){
        return view('devis.devisArchive');
    }

    public function queryArchiveDevis(Request $request){
        $clients = Devi::onlyTrashed()->select(array('id','etat_id','deleted_at','created_at','updated_at'));
        $ssData = Datatables::of($clients);
        $ssData = $ssData->editColumn('etat_id','{{\App\Tools\DevisEtatTools::getEtatById($etat_id)->libelle}}');
        $ssData = $ssData->addColumn('butts','<a href="/devis/view?id={{$id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                        /<a href="/devis/download?id={{$id}}" class="downloadButton"> <span class="glyphicon glyphicon-download-alt"></span> </a>');
        $ssData = $ssData->addColumn('restore','<a href="/devis/restore?id={{$id}}"> <span class="glyphicon glyphicon-refresh"></span> </a>');
        $ssData = $ssData->addColumn('total','{{\App\Tools\DevisTools::getTotal($id)}}');
        return $ssData->make(true);
    }

    public function deleteDevis(Request $request){
        $devis = Devi::find($request['id']);
        $connectedUser = Auth::user();
        DevisTools::deleteDevis($connectedUser,$devis);
        return redirect()->back();
    }

    public function restoreDevis(Request $request){
        $connectedUser = Auth::user();
        $err = DevisTools::restoreDevis($connectedUser,$request['id']);
        return redirect('devis/archive')->withErrors($err);
    }

    public function validateDevis(Request $request){
        $connectedUser = Auth::user();
        try {
            DB::beginTransaction();
            $devis = Devi::find($request['id']);
            if ($devis->etat_id == 2) {
                $facture = DevisTools::facturerDevis($connectedUser,$devis);
                FactureTools::sendFactureMail($facture);
            } else if ($devis->etat_id == 1) {
                DevisTools::validerDevis($connectedUser, $devis);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $trace = new Trace();
            $trace->operation = "Validation";
            $trace->type = 'Devis';
            $trace->resultat = false;
            $trace->user()->associate($connectedUser);
            $trace->save();
        }
        return redirect()->back();
    }

    public function devisUpdateShow(Request $request){
        $devis = DevisTools::getDevisById($request['id']);
        $services = ServiceTools::getServices($devis->id);
        $interps_ids = DB::table('devis_interpreteurs')->where('devi_id','=',$devis->id)->get();
        $interps = [];
        foreach ($interps_ids as $id) {
            array_push($interps,InterpreteurTools::getInterpreteur($id->interpreteur_id));
        }
        $demande = DemandeTools::getDemande($devis->demande_id);
        return view('devis.devisUpdate',['services'=>$services,'demande'=>$demande,'devis'=>$devis,'interps' => $interps,'interpreteurs'=>[]]);
    }

    public function devisUpdateStore(Request $request){
        $devis = DevisTools::getDevisById($request['id']);
        $services = ServiceTools::getServices($devis->id);
        $demande = DemandeTools::getDemande($devis->demande_id);
        $connectedUser = Auth::user();
        try {
            DB::beginTransaction();
            $interps = $request['idInterp'];
            $sends = $request['sendMail'];
            DB::table('devis_interpreteurs')->where('devi_id','=',$devis->id)->delete();
            if($interps==null) return view('devis.devisUpdate',['demande'=>$demande,'devis'=>$devis,'interps'=>InterpreteurTools::getInterpreteurByDevis($devis->id)])->withErrors(['Vous devez choisir au moins un inteprete']);
            $attachs = [];
            foreach($interps as $key => $value){
                $interp = InterpreteurTools::getInterpreteur($value);
                if($sends[$key]=='cv' && $interp->cv != 'NULL'){
                    array_push($attachs,storage_path().'/cv/'.$interp->cv);
                }
                if($sends[$key]=='cv_anonyme'  && $interp->cv_anonyme != 'NULL'){
                    array_push($attachs,storage_path().'/cv_anonyme/'.$interp->cv_anonyme);
                }
                $interp->devis()->attach($devis);
            }
            foreach ($services as $service) {
                $service->delete();
            }
            DevisTools::updateDevis($request,$devis,$connectedUser);
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $trace = new Trace();
            $trace->operation = "Modification";
            $trace->type = 'Devis';
            $trace->resultat = false;
            $trace->user()->associate($connectedUser);
            $trace->save();
            DB::commit();
        }
        return $this->devisUpdateShow($request);
    }

    public function downloadDevis(Request $request){
        $devis = DevisTools::getDevisById($request['id']);
        $demande = DemandeTools::getDemande($devis->demande_id);
        $client = ClientTools::getClient($demande->client_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $services = ServiceTools::getServices($devis->id);
        if($devis->trashed()) $services = ServiceTools::getServicesArchive($devis->id);
        return MailTools::downloadAttach('devis',['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis],"Devis_Ref_".$devis->id);
    }

}
