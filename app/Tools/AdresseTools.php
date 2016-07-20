<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/18/16
 * Time: 8:00 PM
 */

namespace App\Tools;


use App\Adresse;

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

    public static function getAdresse($id){
        return Adresse::where(['id'=>$id])->get()->first();
    }

}