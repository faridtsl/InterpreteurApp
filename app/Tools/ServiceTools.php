<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/3/16
 * Time: 3:59 PM
 */

namespace App\Tools;


use App\Service;

class ServiceTools{

    public static function addServices($devis,$a){
        $services = $a['service'];
        $designations = $a['designation'];
        $qte = $a['qte'];
        $prix_unitaire = $a['prixUnitaire'];
        $unite = $a['unite'];
        $tot = 0;
        foreach ($services as $index => $value) {
            $service = new Service();
            $service->service = $value;
            $service->designation = $designations[$index];
            $service->qantite = $qte[$index];
            $service->prix = $prix_unitaire[$index];
            $service->Unite = $unite[$index];
            $service->total = $service->prix * $service->qantite;
            $tot += $service->total;
            $service->devis()->associate($devis);
            $service->save();
        }
        return $tot;
    }

    public static function getServices($devis_id){
        $services = Service::where('devi_id',$devis_id)->get();
        return $services;
    }


    public static function getServicesArchive($devis_id){
        $services = Service::withTrashed()->where('devi_id',$devis_id)->get();
        return $services;
    }


}