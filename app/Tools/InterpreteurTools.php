<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/19/16
 * Time: 12:26 PM
 */

namespace App\Tools;


use App\Adresse;
use App\Interpreteur;

class InterpreteurTools{

    public static function addInterpreteur(Adresse $adr,User $u, $a){
        $interp = new Interpreteur();
        $interp->nom = $a['nom'];
        $interp->prenom = $a['prenom'];
        $interp->email = $a['email'];
        $interp->devise = $a['devise'];
        $interp->prestation = $a['prestation'];
        $interp->tel_portable = $a['tel_portable'];
        $interp->commentaire = $a['commentaire'];
        $interp->tel_fixe = $a['tel_fixe'];
        $interp->image = $a['image'];
        $interp->adresse()->associate($adr);
        $interp->user()->associate($u);
        $interp->save();
        return $interp;
    }

    public static function deleteInterpreteur($id){
        $interp = Interpreteur::find($id);
        $interp->delete();
    }

    public static function updateInterpreteur(Adresse $adr,User $u, $a){
        $interp = Interpreteur::find($a['id']);
        $interp->nom = $a['nom'];
        $interp->prenom = $a['prenom'];
        $interp->email = $a['email'];
        $interp->devise = $a['devise'];
        $interp->prestation = $a['prestation'];
        $interp->tel_portable = $a['tel_portable'];
        $interp->commentaire = $a['commentaire'];
        $interp->tel_fixe = $a['tel_fixe'];
        $interp->image = $a['image'];
        $interp->save();
        return $interp;
    }

}