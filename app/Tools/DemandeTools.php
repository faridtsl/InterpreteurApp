<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/27/16
 * Time: 8:06 PM
 */

namespace App\Tools;


use App\Adresse;
use App\Client;
use App\Demande;
use App\Etat;
use App\Http\Requests\DemandeSearchRequest;
use App\Traduction;
use App\User;
use Carbon\Carbon;

class DemandeTools{

    public static function addDemande(Adresse $adr,Client $client,Etat $etat,Traduction $traduction,User $u,$a){
        $demande = new Demande();
        $demande->titre = $a['titre'];
        $demande->content = $a['content'];
        $demande->dateEvent = $a['dateEvent'];
        $demande->dateEndEvent = $a['dateEndEvent'];
        $demande->adresse()->associate($adr);
        $demande->user()->associate($u);
        $demande->client()->associate($client);
        $demande->traduction()->associate($traduction);
        $demande->etat()->associate($etat);
        $demande->save();
        return $demande;
    }

    public static function searchByDates(DemandeSearchRequest $request){

        if(!empty($request['dateEventDeb'])){
            $demande = Demande::where('dateEvent', '>=', $request['dateEventDeb']);
        }

        if(!empty($request['dateEventFin'])){
            $demande = $demande->where('dateEvent', '<=', $request['dateEventFin']);
        }

        if(!empty($request['dateCreateDeb'])){
            $demande = $demande->where('created_at', '>=', $request['dateCreateDeb']);
        }

        if(!empty($request['dateCreateFin'])){
            $demande = $demande->where('created_at', '<=', $request['dateCreateFin']);
        }

        $demandes = $demande->get();

        return $demandes;
    }

    public static function tempsRestant(Demande $d){
        $dateEvent = new Carbon($d->dateEvent);
        $now = Carbon::now();
        return $now->diffInDays($dateEvent,false);
    }

    public static function updateDemande(Adresse $adr=null,Client $client=null,Etat $etat=null,Traduction $traduction=null,User $u,$a){
        $demande = Demande::find($a['id']);
        if($a['titre'] != null) $demande->titre = $a['titre'];
        if($a['content'] != null) $demande->content = $a['content'];
        if(($a['dateEvent'] != null)) $demande->dateEvent = $a['dateEvent'];
        if($a['dateEndEvent'] != null) $demande->dateEndEvent = $a['dateEndEvent'];
        if($adr != null) $demande->adresse()->associate($adr);
        if($client != null) $demande->client()->associate($client);
        if($traduction != null) $demande->traduction()->associate($traduction);
        if($etat != null) $demande->etat()->associate($etat);
        $demande->save();
        return $demande;
    }

    public static function getDemande($id){
        return Demande::find($id);
    }


}