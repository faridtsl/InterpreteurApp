<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/4/16
 * Time: 3:01 PM
 */

namespace App\Tools;


use App\Facture;

class FactureTools{



    public static function getFacturesByInterp($interp_id){
        $factures = Facture::where('interpreteur_id',$interp_id)->get();
        return $factures;
    }

}