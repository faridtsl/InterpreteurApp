<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/18/16
 * Time: 5:36 PM
 */

namespace App\Tools;



use App\Langue;

class LangueTools{

    public static function addLangue($lib,$cont){
        $l = new Langue();
        $l->libelle = $lib;
        $l->content = $cont;
        $l->save();
        TraductionTools::addTraductions($l);
        return $l;
    }

    public static function getLangue($id){
        return Langue::where(['id'=>$id])->get()->first();
    }

    public static function getAllLangues(){
        return Langue::all();
    }

}