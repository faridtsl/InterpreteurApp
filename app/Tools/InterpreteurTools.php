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
use App\Trace;
use App\Traduction;
use App\User;

class InterpreteurTools{

    public static function addInterpreteur(Adresse $adr,User $u, $a){
        $interp = new Interpreteur();
        $interp->nom = $a['nom'];
        $interp->prenom = $a['prenom'];
        $interp->email = $a['email'];
        $interp->nationalite = $a['nationalite'];
        $interp->devise = $a['devise'];
        $interp->prestation = $a['prestation'];
        $interp->tel_portable = $a['tel_portable'];
        $interp->commentaire = $a['commentaire'];
        $interp->tel_fixe = $a['tel_fixe'];
        $interp->image = $a['imageName'];
        $interp->cv = $a['cvName'];
        $interp->cv_anonyme = $a['cvAnonymeName'];
        $interp->adresse()->associate($adr);
        $interp->user()->associate($u);
        $interp->save();
        $trace = new Trace();
        $trace->operation = 'Creation';
        $trace->type = 'Interpreteur';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $interp->traces()->save($trace);
        return $interp;
    }

    private static function exists(Interpreteur $interpreteur, Traduction $traduction){
        $trads = TraductionTools::getTraductionsByInterpreteur($interpreteur->id);
        foreach ($trads as $trad) {
            if($trad->id == $traduction->id) return 1;
        }
        return 0;
    }

    public static function addTraduction(Interpreteur $interp, Traduction $trad){
        $interp->traductions()->attach($trad);
    }

    public static function addTraductions(Interpreteur $interp,$a){
        $langs_init = $a['langue_src'];
        $langs_dest = $a['langue_dest'];
        if($langs_init == null) return;
        foreach ($langs_init as $index => $value) {
            $src = LangueTools::getLangue($value);
            $dst = LangueTools::getLangue($langs_dest[$index]);
            $traduction = TraductionTools::getTraduction($src, $dst);
            if($traduction != null && ! self::exists($interp,$traduction))
                InterpreteurTools::addTraduction($interp, $traduction);
        }
    }

    public static function deleteInterpreteur(User $u,$id){
        $interp = Interpreteur::find($id);
        $trace = new Trace();
        $trace->operation = 'Suppression';
        $trace->type = 'Interpreteur';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $interp->traces()->save($trace);
        $devis = DevisTools::getDevisByInterp($id);
        foreach ($devis as $devi) {
            DevisTools::deleteDevis($u,$devi);
        }
        $interp->delete();
    }

    public static function restoreInterpreteur(User $u,$id){
        $interp = Interpreteur::withTrashed()
            ->where('id', $id)
            ->get()->first();
        $interp->restore();

        $trace = new Trace();
        $trace->operation = 'Restoration';
        $trace->type = 'Interpreteur';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $interp->traces()->save($trace);
    }

    public static function updateInterpreteur(User $u, $a){
        $interp = Interpreteur::find($a['id']);
        if($a['nom'] != null) $interp->nom = $a['nom'];
        if($a['prenom'] != null) $interp->prenom = $a['prenom'];
        if($a['email'] != null) $interp->email = $a['email'];
        if($a['nationalite'] != null) $interp->nationalite = $a['nationalite'];
        if($a['devise'] != null) $interp->devise = $a['devise'];
        if($a['prestation'] != null) $interp->prestation = $a['prestation'];
        if($a['tel_portable'] != null) $interp->tel_portable = $a['tel_portable'];
        if($a['commentaire'] != null) $interp->commentaire = $a['commentaire'];
        if($a['tel_fixe'] != null) $interp->tel_fixe = $a['tel_fixe'];
        if($a['imageName'] != null) $interp->image = $a['imageName'];
        if($a['cvName'] != null) $interp->cv = $a['cvName'];
        if($a['cvAnonymeName'] != null) $interp->cv_anonyme = $a['cvAnonymeName'];
        $interp->save();

        $trace = new Trace();
        $trace->operation = 'Modification';
        $trace->type = 'Interpreteur';
        $trace->resultat = true;
        $trace->user()->associate($u);
        $interp->traces()->save($trace);
        return $interp;
    }

    public static function getAllInterpreteurs(){
        $interpreteurs = Interpreteur::all();
        return $interpreteurs;
    }


    public static function getArchiveInterpreteurs(){
        $interpreteurs = Interpreteur::onlyTrashed()->get();
        return $interpreteurs;
    }

    public static function getArchiveInterpreteurByDevis($devi_id){
        $res = Interpreteur::onlyTrashed()->join('devis_interpreteurs', 'interpreteurs.id', '=', 'devis_interpreteurs.devi_id')
            ->where('devis_interpreteurs.devi_id',$devi_id)->get();
        return $res;
    }

    public static function getInterpreteurByDevis($devi_id){
        $res = Interpreteur::join('devis_interpreteurs', 'interpreteurs.id', '=', 'devis_interpreteurs.devi_id')
            ->where('devis_interpreteurs.devi_id',$devi_id)->get();
        return $res;
    }

    public static function getInterpreteur($id){
        $interp = Interpreteur::withTrashed()
            ->where('id', $id)
            ->get()->first();
        return $interp;
    }

    public static function canBeDeleted($interpreteur_id){
        $devis = DevisTools::getDevisByInterp($interpreteur_id);
        return count($devis)==0;
    }

    public static function getLanguages($interpreteur){
        $traductions = TraductionTools::getTraductionsByInterpreteur($interpreteur->id);
        $langs = [];
        foreach ($traductions as $trad){
            $l1 = LangueTools::getLangue($trad->cible);
            $l2 = LangueTools::getLangue($trad->source);
            array_push($langs,$l1,$l2);
        }
        $langs = array_unique($langs);
        return $langs;
    }

}