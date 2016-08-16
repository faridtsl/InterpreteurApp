<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/20/16
 * Time: 1:49 PM
 */

namespace App\Tools;


use App\Client;
use App\Demande;
use App\User;

class ClientTools{

    public static function addClient(User $u, $a){
        $client = new Client();
        $client->nom = $a['nom'];
        $client->prenom = $a['prenom'];
        $client->email = $a['email'];
        $client->tel_portable = $a['tel_portable'];
        $client->commentaire = $a['commentaire'];
        $client->tel_fixe = $a['tel_fixe'];
        $client->image = $a['imageName'];
        $client->user()->associate($u);
        $client->save();
        return $client;
    }
    public static function deleteClient(User $u,$id){
        $client = Client::find($id);
        $demandes = DemandeTools::getDemandesByClient($id);
        foreach ($demandes as $demande){
            DemandeTools::deleteDemande($u,$demande);
        }
        $client->delete();
    }

    public static function restoreClient(User $u,$id){
        $client = Client::withTrashed()
            ->where('id', $id)
            ->get()->first();
        $client->restore();
    }

    public static function updateClient(User $u, $a){
        $client = Client::find($a['id']);
        if($a['nom'] != null) $client->nom = $a['nom'];
        if($a['prenom'] != null) $client->prenom = $a['prenom'];
        if($a['email'] != null) $client->email = $a['email'];
        if($a['tel_portable'] != null) $client->tel_portable = $a['tel_portable'];
        if($a['commentaire'] != null) $client->commentaire = $a['commentaire'];
        if($a['tel_fixe'] != null) $client->tel_fixe = $a['tel_fixe'];
        if($a['imageName'] != null) $client->image = $a['imageName'];
        $client->save();
        return $client;
    }


    public static function getAllClients(){
        $clients = Client::all();
        return $clients;
    }


    public static function getArchiveClients(){
        $clients = Client::onlyTrashed()->get();
        return $clients;
    }

    public static function getClient($id){
        $client = Client::withTrashed()
            ->where('id', $id)
            ->get()->first();
        return $client;
    }

    public static function canBeDeleted($client_id){
        $demandes = DemandeTools::getDemandesByClient($client_id);
        foreach ($demandes as $demande){
            $etat = EtatTools::getEtatById($demande->etat_id);
            if($etat->libelle == 'Traitée' || $etat->libelle == 'Finalisée') return false;
        }
        return true;
    }

    public static function getClientByFacture($facture){
        $devis = DevisTools::getDevisById($facture->devi_id);
        $demande = DemandeTools::getDemande($devis->demande_id);
        return self::getClient($demande->client_id);
    }

}