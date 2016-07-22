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
use App\Traduction;
use App\User;

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
        $interp->image = $a['imageName'];
        $interp->adresse()->associate($adr);
        $interp->user()->associate($u);
        $interp->save();
        return $interp;
    }

    public static function addTraduction(Interpreteur $interp, Traduction $trad){
        $interp->traductions()->attach($trad);
    }

    public static function deleteInterpreteur(User $u,$id){
        $interp = Interpreteur::find($id);
        $interp->delete();
    }

    public static function updateInterpreteur(User $u, $a){
        $interp = Interpreteur::find($a['id']);
        if($a['nom'] != null) $interp->nom = $a['nom'];
        if($a['prenom'] != null) $interp->prenom = $a['prenom'];
        if($a['email'] != null) $interp->email = $a['email'];
        if($a['devise'] != null) $interp->devise = $a['devise'];
        if($a['prestation'] != null) $interp->prestation = $a['prestation'];
        if($a['tel_portable'] != null) $interp->tel_portable = $a['tel_portable'];
        if($a['commentaire'] != null) $interp->commentaire = $a['commentaire'];
        if($a['tel_fixe'] != null) $interp->tel_fixe = $a['tel_fixe'];
        if($a['image'] != null) $interp->image = $a['image'];
        $interp->save();
        return $interp;
    }

    public static function getAllInterpreteurs(){
        $interpreteurs = Interpreteur::all();
        return $interpreteurs;
    }

    public static function getInterpreteur($id){
        $interp = Interpreteur::find($id);
        return $interp;
    }

}