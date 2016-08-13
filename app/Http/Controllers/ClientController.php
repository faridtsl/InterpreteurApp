<?php

namespace App\Http\Controllers;

use App\Tools\AdresseTools;
use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
use App\Tools\ImageTools;
use App\Tools\ClientTools;
use App\Tools\LangueTools;
use App\Tools\TraductionTools;
use Illuminate\Http\Request;
use App\Tools\MailTools;

use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ClientController extends Controller{

    public function show(){
        return view('client.clientAdd');
    }

    public function store(ClientRequest $request){
        try {
            DB::beginTransaction();
            $connectedUser = Auth::user();
            $image = Input::file('image');
            $imgName = '';
            if ($image == null) {
                $imgName = 'unknown.jpg';
            } else {
                $imgName = ImageTools::getName($image, $request);
                Input::file('image')->move(storage_path() . '/img', $imgName);
            }
            $request['imageName'] = $imgName;
            $client = ClientTools::addClient($connectedUser, $request);
            DB::commit();
            MailTools::sendMail('Profil client créé','createClient','creadis.test@gmail.com',$client->email,[],['client'=>$client],'public/css/mailStyle.css');
            return view('client.clientAdd', ['message' => 'Client ajouté avec success!', 'img' => $imgName, 'client' => $client]);
        }catch(\Exception $e){
            DB::rollback();
        }
        $errors = ['Un probleme s\'est survenu veuillez resseayer'];
        return view('client.clientAdd')->withErrors($errors);
    }

    public function showClients(){
        $clients = ClientTools::getAllClients();
        return view('client.clientsShow',['clients'=>$clients]);
    }

    public function archiveClients(){
        $clientsArchive = ClientTools::getArchiveClients();
        return view('client.clientArchive',['clients'=>$clientsArchive]);
    }

    public function showClient(Request $request){
        return response(ClientTools::getClient($request['id']));
    }


    public function updateClient(Request $request){
        $connectedUser = Auth::user();
        $client = ClientTools::getClient($request['id']);
        $image = Input::file('image');
        if ($image == null) {
            $imgName = $client->image;
        } else {
            $imgName = $client->image;
            if($imgName == 'unknown.jpg')
                $imgName = ImageTools::getName($image, $request);
            Input::file('image')->move(storage_path() . '/img', $imgName);
        }
        $request['imageName'] = $imgName;
        ClientTools::updateClient($connectedUser,$request);
        return redirect()->back();
    }

    public function deleteClient(Request $request){
        $connectedUser = Auth::user();
        if(ClientTools::canBeDeleted($request['id'])) {
            ClientTools::deleteClient($connectedUser, $request['id']);
        }else{
            return redirect()->back()->withErrors(['Le client a des commandes non terminées']);
        }
        return redirect()->back()->with('message','Client supprimé avec success');
    }

    public function restoreClient(Request $request){
        $connectedUser = Auth::user();
        ClientTools::restoreClient($connectedUser,$request['id']);
        return redirect('client/archive');
    }

    public function profileClient(Request $request){
        $client = ClientTools::getClient($request['id']);
        $demandes = DemandeTools::getDemandesByClient($client->id);
        $devis = [];
        $factures = [];
        foreach ($demandes as $demande){
            $devs = DevisTools::getDevis($demande->id);
            if($devs != null){
                foreach ($devs as $dev) {
                    array_push($devis, $dev);
                    $fact = FactureTools::getFactureByDevis($dev->id);
                    if ($fact != null) array_push($factures, $fact);
                }
            }
        }
        return view('client.profileClient',['client'=>$client,'demandes'=>$demandes,'factures'=>$factures,'devis'=>$devis]);
    }


    public function profileArchiveClient(Request $request){
        $client = ClientTools::getClient($request['id']);
        $demandes = DemandeTools::getArchiveDemandesByClient($client->id);
        $demandesCour = DemandeTools::getDemandesByClient($client->id);
        $devis = [];
        $factures = [];
        foreach ($demandes as $demande){
            $devs = DevisTools::getArchiveDevisByDemander($demande->id);
            if($devs != null){
                foreach ($devs as $dev) {
                    array_push($devis, $dev);
                    $fact = FactureTools::getFactureByDevis($dev->id);
                    if ($fact != null) array_push($factures, $fact);
                }
            }
        }

        foreach ($demandesCour as $demande){
            $devs = DevisTools::getArchiveDevisByDemander($demande->id);
            if($devs != null){
                foreach ($devs as $dev) {
                    if($dev->trashed()) array_push($devis, $dev);
                    $fact = FactureTools::getFactureByDevis($dev->id);
                    if ($fact != null && $fact->trashed()) array_push($factures, $fact);
                }
            }
        }
        return view('client.profileArchiveClient',['client'=>$client,'demandes'=>$demandes,'factures'=>$factures,'devis'=>$devis]);
    }

}
