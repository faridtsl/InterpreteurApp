<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/3/16
 * Time: 3:52 PM
 */

namespace App\Tools;


use App\Demande;
use App\Devi;
use App\DevisEtat;
use App\Etat;
use App\Service;
use App\Trace;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class DevisTools{

    public static function addDevis($request,User $u){
        $devis = new Devi();
        $etat_devis = DevisEtatTools::getEtatById(1);
        $demande = DemandeTools::getDemande($request['demande_id']);
        $interp = InterpreteurTools::getInterpreteur($request['interpreteur_id']);
        $devis->interpreteur()->associate($interp);
        $devis->demande()->associate($demande);
        $devis->user()->associate($u);
        $devis->etat()->associate($etat_devis);
        $devis->save();
        $devis->total = ServiceTools::addServices($devis,$request);
        $devis->save();
        if($demande->etat_id == 1) {
            $demande->etat()->associate(EtatTools::getEtatById(2));
            $demande->save();
        }
        $trace = new Trace();
        $trace->operation = 'Creation';
        $trace->type = 'Devis';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $devis->traces()->save($trace);
        return $devis;
    }


    public static function updateDevis($request,$devis,User $u){
        $interp = InterpreteurTools::getInterpreteur($request['interpreteur_id']);
        $devis->interpreteur()->associate($interp);
        $devis->user()->associate($u);
        $devis->total = ServiceTools::addServices($devis,$request);
        $devis->save();
        $trace = new Trace();
        $trace->operation = 'Modification';
        $trace->type = 'Devis';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $devis->traces()->save($trace);
        return $devis;
    }

    public static function getDevis($demande_id){
        $devis = Devi::where('demande_id',$demande_id)->get();
        return $devis;
    }


    public static function getArchiveDevisByDemander($demande_id){
        $devis = Devi::withTrashed()->where('demande_id',$demande_id)->get();
        return $devis;
    }

    public static function getDevisByDemander($demande_id){
        $devis = Devi::where('demande_id',$demande_id)->get();
        return $devis;
    }

    public static function getDevisById($id){
        $devis = Devi::withTrashed()->where('id',$id)->get()->first();
        return $devis;
    }

    public static function getDevisByInterp($interpreteur_id){
        $devis = Devi::where('interpreteur_id',$interpreteur_id)->get();
        return $devis;
    }

    public static function getArchiveByInterp($interpreteur_id){
        $devis = Devi::onlyTrashed()->where('interpreteur_id',$interpreteur_id)->get();
        return $devis;
    }

    public static function getTotal($id){
        $services = Service::where('devi_id',$id)->get();
        $tot = 0;
        foreach ($services as $service){
            $tot += $service->total;
        }
        return $tot;
    }

    public static function sendDevisMail($devis){
        $demande = Demande::find($devis->demande_id);
        $client = ClientTools::getClient($demande->client_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $services = ServiceTools::getServices($devis->id);
        $params = ['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis];
        $params['PDF'] = 'set';
        $pdf = PDF::loadView('emails.devis', $params);
        $pdf->save(storage_path().'/devis.pdf');
        $params['PDF'] = null;
        MailTools::sendMail('NEW QUOTATION HAS BEEN CREATED','devis','creadis.test@gmail.com',$client->email,[public_path().'/devis.pdf'],$params,'public/css/style_df.css');
    }

    public static function deleteDevis(User $u,$devis){
        $facture = FactureTools::getFactureByDevis($devis->id);
        if($devis->etat_id!=3 || ($facture == null || $facture->fini)){
            $trace = new Trace();
            $trace->operation = 'Suppression';
            $trace->type = 'Devis';
            $trace->resultat = true;
            $trace->user()->associate($u);
            $devis->traces()->save($trace);
            $devis->delete();
        }else return false;
        $demande = DemandeTools::getDemande($devis->demande_id);
        if($demande->etat_id != 4) {
            if($demande->etat_id == 3 && count((DevisTools::getDevisByDemander($demande->id))->filter(function($devi){return $devi->etat_id == 2;}))==0) {
                $demande->etat()->associate(EtatTools::getEtatById(2));
                $demande->save();
            }
            if($demande->etat_id==2 && count((DevisTools::getDevisByDemander($demande->id))->filter(function($devi){return $devi->etat_id == 1;}))==0){
                $demande->etat()->associate(EtatTools::getEtatById(1));
                $demande->save();
            }
        }
        return true;
    }

    public static function restoreDevis(User $u,$devis_id){
        $devis = Devi::withTrashed()
            ->where('id', $devis_id)
            ->get()->first();
        $err = [];
        $demande = DemandeTools::getDemande($devis->demande_id);
        if(DevisTools::canBeRestored($devis)) {
            $devis->restore();
            $trace = new Trace();
            $trace->operation = 'Restoration';
            $trace->type = 'Devis';
            $trace->resultat = true;
            $trace->user()->associate($u);
            $devis->traces()->save($trace);
            if($demande->etat_id == 1) {
                $demande->etat()->associate(EtatTools::getEtatById(2));
                $demande->save();
            }
        }else{
            $interpreteur = InterpreteurTools::getInterpreteur($devis->interpreteur_id);
            $err = [];
            if($demande->trashed() || !DemandeTools::canBeRestored($demande)) $err = ['La demande a été supprimée'];
            if($interpreteur->trashed()) array_push($err,'l\'interpréte a été supprimé ');
        }
        return $err;
    }

    public static function getArchiveDevis(){
        $devis = Devi::onlyTrashed()->get();
        return $devis;
    }

    public static function canBeRestored($devis){
        $interpreteur = InterpreteurTools::getInterpreteur($devis->interpreteur_id);
        $demande = DemandeTools::getDemande($devis->demande_id);
        return DemandeTools::canBeRestored($demande) && !$interpreteur->trashed() && !$demande->trashed();
    }

    public static function validerDevis(User $u,$devis){
        $etat = DevisEtatTools::getEtatById(2);
        $demande = DemandeTools::getDemande($devis->demande_id);
        $demande->etat()->associate(EtatTools::getEtatById(3));
        $demande->save();
        $devis->etat()->associate($etat);
        $devis->save();
        $trace = new Trace();
        $trace->operation = 'Reserver';
        $trace->type = 'Devis';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $devis->traces()->save($trace);
    }

    public static function facturerDevis(User $u,$devis){
        $facture = FactureTools::addFacture($devis,$u);
        $etat = DevisEtatTools::getEtatById(3);
        $devis->etat()->associate($etat);
        $devis->save();
        return $facture;
    }

    public static function getAllDevis(){
        $devis = Devi::all();
        return $devis;
    }


    public static function tempsRestant($dev){
        $date_creation = new Carbon($dev->created_at);
        $now = Carbon::now();
        return $now->diffInDays($date_creation,false);
    }

    public static function tempsRestantFinEvent($dev){
        $demande = DemandeTools::getDemande($dev->id);
        return DemandeTools::tempsRestantFinEvent($demande);
    }

}