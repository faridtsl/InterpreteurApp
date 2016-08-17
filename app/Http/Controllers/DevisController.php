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
use App\User;
use Illuminate\Http\Request;
use App\Tools\MailTools;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller{

    public function show(Request $request){
        $demande = Demande::find($request['id']);
        $interpreteurs = InterpreteurTools::getAllInterpreteurs();
        return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs]);
    }

    public function store(Request $request){
        $connectedUser = Auth::user();
        $demande = Demande::find($request['demande_id']);
        $client = ClientTools::getClient($demande->client_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $interpreteurs = InterpreteurTools::getAllInterpreteurs();
        try {
            DB::beginTransaction();
            $devis = DevisTools::addDevis($request,$connectedUser);
            $services = ServiceTools::getServices($devis->id);
            MailTools::sendMail('NEW QUOTATION HAS BEEN CREATED','devis','creadis.test@gmail.com',$client->email,[],['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis],'public/css/style_df.css');
            DB::commit();
            return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs,'message'=>'Devis ajouté avec success']);
        }catch(\Exception $e){
            DB::rollback();
        }
        $errors = ['Une erreur s\'est survenu veuillez reverifier vos données'];
        return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs])->withErrors($errors);
    }

    public function showDevis(Request $request){
        $devis = Devi::all();
        return view('devis.devisShow',['devis'=>$devis]);
    }

    public function resendDevis(Request $request){
        $devis = Devi::find($request['id']);
        DevisTools::sendDevisMail($devis);
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
        $devis = DevisTools::getArchiveDevis();
        return view('devis.devisArchive',['devis'=>$devis]);
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
        try {
            DB::beginTransaction();
            $devis = Devi::find($request['id']);
            $connectedUser = Auth::user();
            if ($devis->etat_id == 2) {
                $facture = DevisTools::facturerDevis($devis);
                FactureTools::sendFactureMail($facture);
            } else if ($devis->etat_id == 1) {
                DevisTools::validerDevis($connectedUser, $devis);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->back();
    }

    public function devisUpdateShow(Request $request){
        $devis = DevisTools::getDevisById($request['id']);
        $services = ServiceTools::getServices($devis->id);
        $interpreteur = InterpreteurTools::getInterpreteur($devis->interpreteur_id);
        $interpreteurs = InterpreteurTools::getAllInterpreteurs();
        $demande = DemandeTools::getDemande($devis->demande_id);
        return view('devis.devisUpdate',['services'=>$services,'demande'=>$demande,'devis'=>$devis,'interp' => $interpreteur,'interpreteurs'=>$interpreteurs]);
    }

    public function devisUpdateStore(Request $request){
        $devis = DevisTools::getDevisById($request['id']);
        $services = ServiceTools::getServices($devis->id);

        try {
            DB::beginTransaction();
            foreach ($services as $service) {
                $service->delete();
            }
            $connectedUser = Auth::user();
            DevisTools::updateDevis($request,$devis,$connectedUser);
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return $this->devisUpdateShow($request);
    }



}
