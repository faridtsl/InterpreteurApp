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

    public static function getTraductionsByInterpreteur($id){
        $res = Traduction::join('interpreteurs_traductions', 'traductions.id', '=', 'interpreteurs_traductions.traduction_id')
            ->where('interpreteurs_traductions.interpreteur_id',$id)->get();
        return $res;
    }

    public static function getTraductionsByDemande($id){
        $res = Traduction::join('demandes_traductions', 'traductions.id', '=', 'demandes_traductions.traduction_id')
            ->where('demandes_traductions.demande_id',$id)->get();
        return $res;
    }

    public static function getTraductionById($id){
        return Traduction::find($id);
    }

}