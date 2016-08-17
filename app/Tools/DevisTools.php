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
use App\User;
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
        $demande->etat()->associate(EtatTools::getEtatById(2));
        $demande->save();
        return $devis;
    }


    public static function updateDevis($request,$devis,User $u){
        $interp = InterpreteurTools::getInterpreteur($request['interpreteur_id']);
        $devis->interpreteur()->associate($interp);
        $devis->user()->associate($u);
        $devis->total = ServiceTools::addServices($devis,$request);
        $devis->save();
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
        MailTools::sendMail('NEW QUOTATION HAS BEEN CREATED','devis','creadis.test@gmail.com',$client->email,[],['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis],'public/css/style_df.css');
    }

    public static function deleteDevis(User $u,$devis){
        $facture = FactureTools::getFactureByDevis($devis);
        if($facture == null || $facture->fini) $devis->delete();
        else return false;
        $demande = DemandeTools::getDemande($devis->demande_id);
        if(count(DevisTools::getArchiveDevisByDemander($demande->id))==0){
            $demande->etat()->associate(EtatTools::getEtatById(2));
            $demande->save();
        }
        return true;
    }

    public static function restoreDevis(User $u,$devis_id){
        $devis = Devi::withTrashed()
            ->where('id', $devis_id)
            ->get()->first();
        $err = [];
        if(DevisTools::canBeRestored($devis)) {
            $devis->restore();
        }else{
            $interpreteur = InterpreteurTools::getInterpreteur($devis->interpreteur_id);
            $demande = DemandeTools::getDemande($devis->demande_id);
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
        $devs = DevisTools::getArchiveDevisByDemander($demande->id);
        if($devs != null)
            foreach ($devs as $dev) {
                if($dev->id != $devis->id) $dev->delete();
            }
        $demande->etat()->associate(EtatTools::getEtatById(3));
        $demande->save();
        $devis->etat()->associate($etat);
        $devis->save();
    }

    public static function facturerDevis($devis){
        $facture = FactureTools::addFacture($devis);
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