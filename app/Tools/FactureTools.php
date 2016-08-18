<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/4/16
 * Time: 3:01 PM
 */

namespace App\Tools;


use App\Devi;
use App\Facture;
use App\Trace;
use App\User;
use Carbon\Carbon;

class FactureTools{

    public static function getFacturesByInterp($interp_id){
        $factures = Facture::where('interpreteur_id',$interp_id)->get();
        return $factures;
    }

    public static function addFacture($devis,User $u){
        $facture = new Facture();
        $facture->fini = false;
        $facture->date_envoi_mail = Carbon::now();
        $facture->devis()->associate($devis);
        $facture->save();
        $trace = new Trace();
        $trace->operation = 'Creation';
        $trace->type = 'Facture';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $facture->traces()->save($trace);
        $demande = DemandeTools::getDemande($devis->demande_id);
        $demande->etat()->associate(EtatTools::getEtatById(4));
        $demande->save();
        return $facture;
    }


    public static function updateFacture($devis,$a,User $u){
        $facture = Facture::find($a['id']);
        if($a['fini'] != null) $facture->fini = $a['fini'];
        if($a['date_paiement'] != null) $facture->date_paiement = $a['date_paiement'];
        if($devis != null) $facture->devis()->associate($devis);
        $facture->save();
        $trace = new Trace();
        $trace->operation = 'Modification';
        $trace->type = 'Facture';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $facture->traces()->save($trace);
        return $facture;
    }

    public static function deleteFacture($id,User $u){
        $facture = Facture::find($id);
        $trace = new Trace();
        $trace->operation = 'Suppression';
        $trace->type = 'Facture';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $facture->traces()->save($trace);
        $facture->delete();
    }

    public static function restoreFacture($id,User $u){
        $facture = Facture::withTrashed()
            ->where('id',$id)
            ->get()->first();
        $facture->restore();

        $trace = new Trace();
        $trace->operation = 'Restoration';
        $trace->type = 'Facture';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $facture->traces()->save($trace);
    }


    public static function getFactureById($id){
        $facture = Facture::withTrashed()
            ->where('id',$id)
            ->get()->first();
        return $facture;
    }

    public static function getFactureByDevis($devi_id){
        $facture = Facture::withTrashed()
            ->where('devi_id',$devi_id)
            ->get()->first();
        return $facture;
    }

    public static function getFactures(){
        $factures = Facture::all();
        return $factures;
    }

    public static function getArchiveFactures(){
        $factures = Facture::onlyTrashed()->get();
        return $factures;
    }

    public static function tempsRestant($f){
        $date_envoi = new Carbon($f->date_envoi_email);
        $now = Carbon::now();
        return $now->diffInDays($date_envoi,false);
    }

    public static function sendFactureMail($facture){
        $devis = Devi::find($facture->devi_id);
        $demande = DemandeTools::getDemande($devis->demande_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $client = ClientTools::getClient($demande->client_id);
        $services = ServiceTools::getServices($devis->id);
        MailTools::sendMail('NEW ORDER HAS BEEN CREATED', 'facturation', 'creadis.test@gmail.com', $client->email, [], ['facture'=>$facture,'services' => $services, 'client' => $client, 'demande' => $demande, 'adresse' => $adresse, 'devis' => $devis], 'public/css/style_df.css');
    }

    public static function resendFacture($facture){
        $facture->date_envoi_mail = Carbon::now();
        $facture->save();
        self::sendFactureMail($facture);
    }

    public static function paiementFacture($facture){
        $facture->fini = true;
        $facture->date_paiement = Carbon::now();
        $facture->save();
    }

    public static function getFactureByDemande($demande){
        $devis = DevisTools::getArchiveDevisByDemander($demande->id);
        $factures = [];
        foreach ($devis as $devi) {
            $fact = FactureTools::getFactureByDevis($devi->id);
            if($fact != null) array_push($factures,$fact);
        }
        return $factures;
    }

}
