<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/18/16
 * Time: 8:00 PM
 */

namespace App\Tools;


use App\Adresse;
use App\User;

class AdresseTools{

    public static function addAdresse($a){
        $adr = new Adresse();
        $adr->adresse = $a['adresse'];
        $adr->numero = $a['numero'];
        $adr->route = $a['route'];
        $adr->code_postal = $a['code_postal'];
        $adr->ville = $a['ville'];
        $adr->pays = $a['pays'];
        $adr->departement = $a['departement'];
        $adr->long = $a['long'];
        $adr->lat = $a['lat'];
        $adr->save();
        return $adr;
    }

    public static function updateAdresse(User $u,$a){
        $adr = Adresse::find($a['adresse_id']);
        if($a['adresse'] != null) $adr->adresse = $a['adresse'];
        if($a['numero'] != null) $adr->numero = $a['numero'];
        if($a['route'] != null) $adr->route = $a['route'];
        if($a['code_postal'] != null) $adr->code_postal = $a['code_postal'];
        if($a['ville'] != null) $adr->ville = $a['ville'];
        if($a['pays'] != null) $adr->pays = $a['pays'];
        if($a['departement'] != null) $adr->departement = $a['departement'];
        if($a['long'] != null) $adr->long = $a['long'];
        if($a['lat'] != null) $adr->lat = $a['lat'];
        $adr->save();
        return $adr;
    }

    public static function getAdresse($id){
        return Adresse::where(['id'=>$id])->get()->first();
    }

}