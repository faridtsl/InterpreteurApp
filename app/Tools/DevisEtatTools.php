<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/9/16
 * Time: 11:01 PM
 */

namespace App\Tools;


use App\DevisEtat;

class DevisEtatTools{

    public static function addEtat($lib){
        $e = new DevisEtat();
        $e->libelle = $lib;
        $e->save();
        return $e;
    }

    public static function getAllEtat(){
        return DevisEtat::all();
    }

    public static function getEtatByName($name){
        return DevisEtat::where('libelle',$name)->get()->first();
    }

    public static function getEtatById($id){
        return DevisEtat::find($id);
    }

    public static function getClassById($id){
        $etat = EtatTools::getEtatById($id);
        $ret = "default";
        if($etat->libelle == "Créé") $ret = "warning";
        if($etat->libelle == "Commande") $ret = "info";
        if($etat->libelle == "Validé") $ret = "success";
        return $ret;
    }


}