<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Http\Requests\DemandeSearchRequest;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\EtatTools;
use App\Tools\FactureTools;
use App\Tools\LangueTools;
use App\Tools\TraductionTools;
use App\Trace;
use Illuminate\Http\Request;
use App\Http\Requests\DemandeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Tools\MailTools;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;

class DemandeController extends Controller{


    public function show(){
        $langues = LangueTools::getAllLangues();
        return view('demande.demandeAdd', ['langues' => $langues]);
    }

    public function store(DemandeRequest $request){
        $langues = LangueTools::getAllLangues();
        $clients = ClientTools::getAllClients();
        $connectedUser = Auth::user();
        try {
            DB::beginTransaction();
            $adresse = AdresseTools::addAdresse($request);
            $etat = EtatTools::getEtatById(1);
            $client = ClientTools::getClient($request['client']);
                //return view('demande.demandeAdd',['langues' => $langues,'clients' => $clients])->withErrors(['Langue source doit être differente de la langues destination']);
            $demande = DemandeTools::addDemande($adresse,$client,$etat,$connectedUser,$request);
            DemandeTools::addTraductions($demande,$request);
            if($request['sendMail'] == 1) MailTools::sendMail('Demande créée','createDemande','creadis.test@gmail.com',$client->email,[],['client'=>$client,'demande'=>$demande,'adresse'=>$adresse],'public/css/mailStyle.css');
            DB::commit();
            return view('demande.demandeAdd', ['message' => 'Demande ajoutée avec success!','client' => $client, 'clients' => $clients,'langues' => $langues, 'demande' => $demande]);
        }catch(\Exception $e){
            DB::rollback();
        }
        $trace = new Trace();
        $trace->operation = "Creation";
        $trace->type = 'Demande';
        $trace->resultat = false;
        $trace->user()->associate($connectedUser);
        $trace->save();
        $errors = ['Veuillez remplire toutes la correspondance src->dest'];
        return view('demande.demandeAdd', ['langues' => $langues,'clients' => $clients])->withErrors($errors);
    }

    public function showList(Request $request){
        $demandes = Demande::all();
        if($request->isMethod('post')){
            $demandes = DemandeTools::searchByDates($request);
        }
        $demandes = $demandes->sortBy(function($demande){
            return $demande->dateEvent;
        });
        return view('demande.demandeShow',['demandes'=>$demandes]);
    }

    public function showCalendar(){
        $demandes = Demande::all();
        return view('demande.calendar', [ 'demandes' => $demandes ] );
    }

    public function showUpdate(Request $request){
        $demande = Demande::find($request['id']);
        if($demande == null) return redirect('/demande/archive');
        $traduction = TraductionTools::getTraductionById($demande->traduction_id);
        $langues = LangueTools::getAllLangues();
        $client = ClientTools::getClient($demande->client_id);
        $factures = FactureTools::getFactureByDemande($demande);
        return view('demande.demandeUpdate',['client'=>$client,'langues'=>$langues,'traduction'=>$traduction,'demande'=>$demande,'factures'=>$factures]);
    }

    public function storeUpdate(Request $request){
        $connectedUser = Auth::user();
        $etat = EtatTools::getEtatByName('NULL');
        $client = ClientTools::getClient($request['client']);
        if($request['idD'] != null) $request['id'] = $request['idD'];
        $demande = DemandeTools::updateDemande(null,$client,$etat,$connectedUser,$request);
        DemandeTools::addTraductions($demande,$request);
        return $this->showUpdate($request);
    }

    public function duplicateDemande(Request $request){
        $demande = Demande::find($request['id']);
        $demande->traduction = TraductionTools::getTraductionById($demande->traduction_id);
        $demande->adr = AdresseTools::getAdresse($demande->adresse_id);
        $demande->client = ClientTools::getClient($demande->client_id);
        $demande->etat = EtatTools::getEtatById($demande->etat_id);
        $connectedUser = Auth::user();
        DemandeTools::dupDemande($connectedUser,$demande);
        $demandes = Demande::all();
        return view('demande.demandeShow',['demandes'=>$demandes,'message'=>'Demande dupliquée avec success']);
    }


    public function archiveDemandes(){
        return view('demande.demandeArchive');
    }

    public function queryArchiveDemandes(Request $request){
        $clients = Demande::onlyTrashed()->join('adresses','demandes.adresse_id','=','adresses.id')->select(array('demandes.id','titre','etat_id','dateEvent','dateEndEvent','adresses.adresse','demandes.deleted_at','demandes.created_at','demandes.updated_at'));
        $ssData = Datatables::of($clients);
        $ssData = $ssData->editColumn('etat_id','{{\App\Tools\EtatTools::getEtatById($etat_id)->libelle}}');
        $ssData = $ssData->addColumn('butts','<a title="View" class="btn btn-info btn-xs seeButton" href="/demande/details?id={{$id}}" >
                                                <span class="glyphicon glyphicon-search"></span>
                                            </a>');
        $ssData = $ssData->addColumn('trads','
                            |
                            @foreach(\App\Tools\TraductionTools::getTraductionsByDemande($id) as $traduction)
                                {{\App\Tools\LangueTools::getLangue($traduction->source)->content}} <span class="glyphicon glyphicon-arrow-right"></span> {{\App\Tools\LangueTools::getLangue($traduction->cible)->content}}
                                |
                            @endforeach');
        return $ssData->make(true);
    }


    public function restoreDemande(Request $request){
        $connectedUser = Auth::user();
        $err = DemandeTools::restoreDemande($connectedUser,$request['id']);
        return redirect('demande/archive')->withErrors($err);
    }

    public function deleteDemande(Request $request){
        $connectedUser = Auth::user();
        $demande = Demande::find($request['id']);
        if($request['can']=='?' && DemandeTools::canBeDeleted($demande) && EtatTools::getEtatById($demande->etat_id)->libelle == 'En cours'){
            $msg = 'Cette demande à des devis envoyés aux clients, êtes-vous sur de bien vouloir le supprimer ?';
            return redirect()->back()->with('message2', $msg)
                ->with('id',$request['id']);
        }
        if(DemandeTools::canBeDeleted($demande)) {
            DemandeTools::deleteDemande($connectedUser, $demande);
            return redirect()->back()->with('message', 'Demande supprimée avec success');
        }else{
            $err = ['Demande a une commande en cours'];
            return redirect()->back()->withErrors($err);
        }
    }

    public function getDemande($id){
        return response(DemandeTools::getDemande($id));
    }

    public function getDemandeByYear(Request $request){
        $resF = [];
        $resT = [];
        $ms = [1,2,3,4,5,6,7,8,9,10,11,12];
        $precTot = 0;
        foreach ($ms as $m) {
            $q = Demande::where('etat_id','=','4')->whereYear('created_at', '=', date($request['y']));
            $d = date($m);
            $ds = $q->whereMonth('created_at','=',$d)->get();
            array_push($resF,count($ds));
        }
    }

    public function showDemandeDetails(Request $request){
        $demande = DemandeTools::getDemande($request['id']);
        if($demande == null) return redirect('/demande/archive');
        $traduction = TraductionTools::getTraductionById($demande->traduction_id);
        $langues = LangueTools::getAllLangues();
        $client = ClientTools::getClient($demande->client_id);
        $factures = FactureTools::getFactureByDemande($demande);
        $devs = DevisTools::getArchiveDevisByDemander($request['id']);
        $archFact = [];
        foreach ($devs as $dev) {
            $fact = FactureTools::getFactureByDevis($dev->id);
            if ($fact != null && $fact->trashed()) array_push($archFact, $fact);
        }
        return view('demande.demandeDetails',['archiveFactures'=>$archFact,'client'=>$client,'langues'=>$langues,'traduction'=>$traduction,'demande'=>$demande,'factures'=>$factures]);
    }


}
