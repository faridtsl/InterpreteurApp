<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/18/16
 * Time: 5:44 PM
 */

namespace App\Tools;


use App\Langue;
use App\Traduction;
use Carbon\Carbon;

class TraductionTools{

    public static function addTraductions(Langue $langue){
        $lngs = Langue::all();
        $mytime = Carbon::now();
        $cols['created_at'] = $mytime;
        $cols['updated_at'] = $mytime;
        foreach ($lngs as $l){
            if($l->id != $langue->id) {
                $l->cible()->attach($langue,$cols);
                $l->source()->attach($langue,$cols);
            }
        }
    }

    public static function getTraduction(Langue $src, Langue $dst){
        $whereClause = ['source'=>$src->id,'cible'=>$dst->id];
        $traduction = Traduction::where($whereClause)->get()->first();
        return $traduction;
    }

    public static function getAllTraductions(){
        return Traduction::all();
    }

}