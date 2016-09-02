<?php

namespace App\Http\Controllers;

use App\Devi;
use App\Facture;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
use App\Tools\MailTools;
use App\Tools\ServiceTools;
use App\Trace;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class FactureController extends Controller{


    public function showFactures(Request $request){
        $factures = Facture::all();
        if($request->isMethod('post')){
            $factures = FactureTools::searchByDates($request);
        }
        return view('facture.factureShow',['factures'=>$factures]);
    }

    public function resendFacture(Request $request){
        $facture = FactureTools::getFactureById($request['id']);
        FactureTools::resendFacture($facture);
    }

    public function paiementFacture(Request $request){
        $connectedUser = Auth::user();
        try {
            DB::beginTransaction();
            $facture = FactureTools::getFactureById($request['id']);
            FactureTools::paiementFacture($facture,$connectedUser);
            $devis = Devi::find($facture->devi_id);
            $demande = DemandeTools::getDemande($devis->demande_id);
            DevisTools::deleteDevis($connectedUser,$devis);
            if(count(DevisTools::getDevisByDemander($demande->id)->filter(function ($devi){return $devi->etat_id == 3 || $devi->etat_id == 2;}))==0) DemandeTools::deleteDemande($connectedUser,$demande);
            FactureTools::deleteFacture($facture->id,$connectedUser);
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $trace = new Trace();
            $trace->operation = "Paiement";
            $trace->type = 'Facture';
            $trace->resultat = false;
            $trace->user()->associate($connectedUser);
            $trace->save();
        }
        return redirect()->back();
    }

    public function archiveFactures(Request $request){
        return view('facture.factureArchive');
    }

    public function queryArchiveFactures(Request $request){
        $factures = Facture::onlyTrashed()->select(array('id','fini','date_envoi_mail','devi_id','date_paiement','deleted_at','created_at','updated_at'));
        $ssData = Datatables::of($factures);
        $ssData = $ssData->addColumn('nom','{{\App\Tools\ClientTools::getClientByFactureId($id)->nom}} {{\App\Tools\ClientTools::getClientByFactureId($id)->prenom}}');
        $ssData = $ssData->addColumn('pay','@if($fini){{$date_paiement}}@else Non Payée @endif');
        $ssData = $ssData->addColumn('butts','<a href="/devis/view?id={{$devi_id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                        /<a href="/devis/download?id={{$devi_id}}" class="downloadButton"> <span class="glyphicon glyphicon-download-alt"></span> </a>');
        $ssData = $ssData->addColumn('fact','<a href="/facture/view?id={{$id}}" class="viewButton"> <span class="glyphicon glyphicon-eye-open"></span> </a>
                        /<a href="/facture/download?id={{$id}}" class="downloadButton"> <span class="glyphicon glyphicon-download-alt"></span> </a>');
        $ssData = $ssData->addColumn('total','{{\App\Tools\DevisTools::getDevisById($devi_id)->total}} &euro;');
        return $ssData->make(true);
    }


    public function viewFacture(Request $request){
        $facture = FactureTools::getFactureById($request['id']);
        $devis = DevisTools::getDevisById($facture->devi_id);
        $demande = DemandeTools::getDemande($devis->demande_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $client = ClientTools::getClient($demande->client_id);
        $services = ServiceTools::getServices($devis->id);
        if($devis->trashed()) $services = ServiceTools::getServicesArchive($devis->id);
        return view('emails.facturation', ['facture'=>$facture,'services' => $services, 'client' => $client, 'demande' => $demande, 'adresse' => $adresse, 'devis' => $devis]);

    }

    public function downloadFacture(Request $request){
        $facture = FactureTools::getFactureById($request['id']);
        $devis = DevisTools::getDevisById($facture->devi_id);
        $demande = DemandeTools::getDemande($devis->demande_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $client = ClientTools::getClient($demande->client_id);
        $services = ServiceTools::getServices($devis->id);
        if($devis->trashed()) $services = ServiceTools::getServicesArchive($devis->id);
        return MailTools::downloadAttach('facturation',['facture'=>$facture,'services' => $services, 'client' => $client, 'demande' => $demande, 'adresse' => $adresse, 'devis' => $devis],"Facture_Ref_".$facture->id);
    }

    public function getFacturesByYear(Request $request){
        $res = [];
        $ms = [1,2,3,4,5,6,7,8,9,10,11,12];
        $names = ['Janv','Fev','Mar','Avr','Mai','Jun','Jul','Aout','Sept','Oct','Nov','Dec'];
        foreach ($ms as $key=>$m) {
            if($request['pred']=='1') $q = Facture::whereYear('created_at', '=', date($request['y']));
            else $q = Facture::where('fini','=','1')->whereYear('created_at', '=', date($request['y']));
            $d = date($m);
            $fs = $q->whereMonth('created_at','=',$d)->get();
            $tot = 0;
            foreach ($fs as $f) {
                $tot += DevisTools::getTotal($f->devi_id);
            }
            $obj = [];
            $obj['y'] = $tot;
            $obj['label'] = $names[$key];
            array_push($res,$obj);
        }
        return response($res);
    }


    public function getCumuleFacturesByYear(Request $request){
        $res = [];
        $ms = [1,2,3,4,5,6,7,8,9,10,11,12];
        $names = ['Janv','Fev','Mar','Avr','Mai','Jun','Jul','Aout','Sept','Oct','Nov','Dec'];
        $precTot = 0;
        foreach ($ms as $key => $m) {
            if($request['pred']=='1') $q = Facture::whereYear('created_at', '=', date($request['y']));
            else $q = Facture::where('fini','=','1')->whereYear('created_at', '=', date($request['y']));
            $d = date($m);
            $fs = $q->whereMonth('created_at','=',$d)->get();
            $tot = $precTot;
            foreach ($fs as $f) {
                $tot += DevisTools::getTotal($f->devi_id);
            }
            $precTot = $tot;
            $obj = [];
            $obj['y'] = $precTot;
            $obj['label'] = $names[$key];
            array_push($res,$obj);
        }
        return response($res);
    }

}
