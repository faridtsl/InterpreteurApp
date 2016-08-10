<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/4/16
 * Time: 3:01 PM
 */

namespace App\Tools;


use App\Facture;
use Carbon\Carbon;

class FactureTools{

    public static function getFacturesByInterp($interp_id){
        $factures = Facture::where('interpreteur_id',$interp_id)->get();
        return $factures;
    }

    public static function addFacture($devis){
        $facture = new Facture();
        $facture->fini = false;
        $facture->date_envoi_mail = Carbon::now();
        $facture->devis()->associate($devis);
        $facture->save();
        return $facture;
    }


    public static function updateFacture($devis,$a){
        $facture = Facture::find($a['id']);
        if($a['fini'] != null) $facture->fini = $a['fini'];
        if($a['date_paiement'] != null) $facture->date_paiement = $a['date_paiement'];
        if($devis != null) $facture->devis()->associate($devis);
        $facture->save();
        return $facture;
    }

    public static function deleteFacture($id){
        $facture = Facture::find($id);
        $facture->delete();
    }

    public static function restoreFacture($id){
        $facture = Facture::withTrashed()
            ->where('id',$id)
            ->get()->first();
        $facture->restore();
    }


    public static function getFactureById($id){
        $facture = Facture::withTrashed()
            ->where('id',$id)
            ->get()->first();
        return $facture;
    }

    public static function getFactureByDevis($devi_id){
        $facture = Facture::withTrashed()
            ->where('devi_id',$devi_id)
            ->get()->first();
        return $facture;
    }

    public static function getFactures(){
        $factures = Facture::all();
        return $factures;
    }

    public static function getArchiveFactures(){
        $factures = Facture::onlyTrashed()->get();
        return $factures;
    }

}
