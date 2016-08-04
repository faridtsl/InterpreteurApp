<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/3/16
 * Time: 3:52 PM
 */

namespace App\Tools;


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

}