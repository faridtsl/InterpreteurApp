<?php

namespace App\Http\Controllers;

use App\Devi;
use App\Facture;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
use App\Tools\ServiceTools;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller{


    public function showFactures(Request $request){
        $factures = Facture::all();
        return view('facture.factureShow',['factures'=>$factures]);
    }

    public function resendFacture(Request $request){
        $facture = FactureTools::getFactureById($request['id']);
        FactureTools::resendFacture($facture);
    }

    public function paiementFacture(Request $request){
        $connectedUser = Auth::user();
        $facture = FactureTools::getFactureById($request['id']);
        FactureTools::paiementFacture($facture);
        $devis = Devi::find($facture->devi_id);
        $demande = DemandeTools::getDemande($devis->demande_id);
        DevisTools::deleteDevis($connectedUser,$devis);
        DemandeTools::deleteDemande($connectedUser,$demande);
        FactureTools::deleteFacture($facture->id);
        return redirect()->back();
    }

    public static function archiveFactures(Request $request){
        $factures = FactureTools::getArchiveFactures();
        return view('facture.factureArchive',['factures'=>$factures]);
    }

    public static function viewFacture(Request $request){
        $facture = FactureTools::getFactureById($request['id']);
        $devis = Devi::find($facture->devi_id);
        //dd([$devis,$facture]);
        $demande = DemandeTools::getDemande($devis->demande_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $client = ClientTools::getClient($demande->client_id);
        $services = ServiceTools::getServices($devis->id);
        return view('emails.facturation', ['facture'=>$facture,'services' => $services, 'client' => $client, 'demande' => $demande, 'adresse' => $adresse, 'devis' => $devis]);

    }

}
