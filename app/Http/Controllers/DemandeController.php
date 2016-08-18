<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Http\Requests\DemandeSearchRequest;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\EtatTools;
use App\Tools\FactureTools;
use App\Tools\LangueTools;
use App\Tools\TraductionTools;
use Illuminate\Http\Request;
use App\Http\Requests\DemandeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Tools\MailTools;
use Illuminate\Support\Facades\View;

class DemandeController extends Controller{


    public function show(){
        $langues = LangueTools::getAllLangues();
        $clients = ClientTools::getAllClients();
        return view('demande.demandeAdd', ['langues' => $langues, 'clients' => $clients]);
    }

    public function store(DemandeRequest $request){
        $langues = LangueTools::getAllLangues();
        $clients = ClientTools::getAllClients();
        try {
            DB::beginTransaction();
            $adresse = AdresseTools::addAdresse($request);
            $connectedUser = Auth::user();
            $etat = EtatTools::getEtatById(1);
            $client = ClientTools::getClient($request['client']);
            $src = LangueTools::getLangue($request['langue_src']);
            $dst = LangueTools::getLangue($request['langue_dest']);
            $traduction = TraductionTools::getTraduction($src,$dst);
            if($traduction==null)
                return view('demande.demandeAdd',['langues' => $langues,'clients' => $clients])->withErrors(['Langue source doit être differente de la langues destination']);
            $demande = DemandeTools::addDemande($adresse,$client,$etat,$traduction,$connectedUser,$request);
            MailTools::sendMail('Demande créée','createDemande','creadis.test@gmail.com',$client->email,[],['client'=>$client,'demande'=>$demande,'adresse'=>$adresse],'public/css/mailStyle.css');
            DB::commit();
            return view('demande.demandeAdd', ['message' => 'Demande ajoutée avec success!','client' => $client, 'clients' => $clients,'langues' => $langues, 'demande' => $demande]);
        }catch(\Exception $e){
            DB::rollback();
        }
        $errors = ['Veuillez remplire toutes la correspondance src->dest'];
        return view('demande.demandeAdd', ['langues' => $langues,'clients' => $clients])->withErrors($errors);
    }

    public function showList(Request $request){
        $demandes = Demande::all();
        if($request->isMethod('post')){
            $demandes = DemandeTools::searchByDates($request);
        }
        $demandes = $demandes->sortBy(function($demande)
        {
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
        $clients = ClientTools::getAllClients();
        $client = ClientTools::getClient($demande->client_id);
        $factures = FactureTools::getFactureByDemande($demande);
        return view('demande.demandeUpdate',['client'=>$client,'langues'=>$langues,'traduction'=>$traduction,'demande'=>$demande,'clients'=>$clients,'factures'=>$factures]);
    }

    public function storeUpdate(Request $request){
        $connectedUser = Auth::user();
        $etat = EtatTools::getEtatByName('NULL');
        $client = ClientTools::getClient($request['client']);
        $src = LangueTools::getLangue($request['langue_src']);
        $dst = LangueTools::getLangue($request['langue_dest']);
        if($src != null && $dst != null) $traduction = TraductionTools::getTraduction($src,$dst);
        else $traduction = null;
        DemandeTools::updateDemande(null,$client,$etat,$traduction,$connectedUser,$request);
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
        $demandesArchive = DemandeTools::getArchiveDemandes();
        return view('demande.demandeArchive',['demandes'=>$demandesArchive]);
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

}
