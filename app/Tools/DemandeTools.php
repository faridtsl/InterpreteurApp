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


}