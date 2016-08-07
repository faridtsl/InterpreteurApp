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
use App\Etat;
use App\Service;
use App\User;

class DevisTools{

    public static function addDevis($request,User $u){
        $devis = new Devi();
        $demande = DemandeTools::getDemande($request['demande_id']);
        $interp = InterpreteurTools::getInterpreteur($request['interpreteur_id']);
        $devis->interpreteur()->associate($interp);
        $devis->demande()->associate($demande);
        $devis->user()->associate($u);
        $devis->save();
        $devis->total = ServiceTools::addServices($devis,$request);
        $devis->save();
        $demande->etat()->associate(EtatTools::getEtatByName('En cours'));
        $demande->save();
        return $devis;
    }

    public static function getDevis($demande_id){
        $devis = Devi::where('demande_id',$demande_id)->get();
        return $devis;
    }

    public static function getDevisByInterp($interpreteur_id){
        $devis = Devi::where('interpreteur_id',$interpreteur_id)->get();
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
        MailTools::sendMail('Devis créée','devis','creadis.test@gmail.com',$client->email,[],['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis],'public/css/style_df.css');
    }

    public static function deleteDevis(User $u,$devis){
        $devis->delete();
    }

    public static function restoreDevis(User $u,$devis_id){
        $devis = Devi::withTrashed()
            ->where('id', $devis_id)
            ->get()->first();
        $err = [];
        if(DevisTools::canBeRestored($devis))
            $devis->restore();
        else{
            $err = ['Devis ne peut pas etre restaurer'];
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

}