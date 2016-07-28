<?php

namespace App\Http\Controllers;

use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\EtatTools;
use App\Tools\LangueTools;
use App\Tools\TraductionTools;
use Illuminate\Http\Request;
use App\Http\Requests\DemandeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller{


    public function show(){
        $langues = LangueTools::getAllLangues();
        $clients = ClientTools::getAllClients();
        return view('demande.demandeAdd', ['langues' => $langues, 'clients' => $clients]);
    }

    public function store(DemandeRequest $request){
        $langues = LangueTools::getAllLangues();
        $clients = ClientTools::getAllClients();
        try {
            DB::beginTransaction();
            $adresse = AdresseTools::addAdresse($request);
            $connectedUser = Auth::user();
            $etat = EtatTools::getEtatByName('Créée');
            $client = ClientTools::getClient($request['client']);
            $src = LangueTools::getLangue($request['langue_src']);
            $dst = LangueTools::getLangue($request['langue_dest']);
            $traduction = TraductionTools::getTraduction($src,$dst);
            $demande = DemandeTools::addDemande($adresse,$client,$etat,$traduction,$connectedUser,$request);
            DB::commit();
            return view('demande.demandeAdd', ['message' => 'Interpreteur ajouté avec success!','client' => $client, 'clients' => $clients,'langues' => $langues, 'demande' => $demande]);
        }catch(\Exception $e){
            DB::rollback();
        }
        $errors = ['Veuillez remplire toutes la correspondance src->dest'];
        return view('demande.demandeAdd', ['langues' => $langues,'clients' => $clients])->withErrors($errors);
    }

}