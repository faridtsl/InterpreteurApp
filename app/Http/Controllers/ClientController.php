<?php

namespace App\Http\Controllers;

use App\Client;
use App\Tools\AdresseTools;
use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
use App\Tools\ImageTools;
use App\Tools\ClientTools;
use App\Tools\LangueTools;
use App\Tools\TraductionTools;
use App\Trace;
use Illuminate\Http\Request;
use App\Tools\MailTools;

use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;

class ClientController extends Controller{

    public function show(){
        return view('client.clientAdd');
    }

    public function store(ClientRequest $request){
        $connectedUser = Auth::user();
        try {
            DB::beginTransaction();
            $adresse = AdresseTools::addAdresse($request);
            $image = Input::file('image');
            $imgName = '';
            if ($image == null) {
                $imgName = 'unknown.jpg';
            } else {
                $imgName = ImageTools::getName($image, $request);
                Input::file('image')->move(storage_path() . '/img', $imgName);
            }
            $request['imageName'] = $imgName;
            $client = ClientTools::addClient($adresse,$connectedUser, $request);
            $trace = new Trace();
            $trace->operation = "Creation";
            $trace->type = 'Client';
            $trace->resultat = true;
            $trace->user()->associate($connectedUser);
            $client->traces()->save($trace);
            MailTools::sendMail('New profile has been created','createClient','creadis.test@gmail.com',$client->email,[],['client'=>$client],'public/css/mailStyle.css');
            DB::commit();
            return view('client.clientAdd', ['message' => 'Client ajouté avec success!', 'img' => $imgName, 'client' => $client]);
        }catch(\Exception $e){
            DB::rollback();
            $trace = new Trace();
            $trace->operation = "Creation";
            $trace->type = 'Client';
            $trace->resultat = false;
            $trace->user()->associate($connectedUser);
            $trace->save();
            DB::commit();
        }
        $errors = ['Un probleme s\'est survenu veuillez resseayer'];
        return view('client.clientAdd')->withErrors($errors);
    }

    public function showClients(){
        //$clients = ClientTools::getAllClients();
        return view('client.clientsShow');
    }

    public function queryClients(Request $request){
        $clients = Client::join('adresses','clients.adresse_id','=','adresses.id')->select(array('clients.id','nom','prenom','email','adresse','tel_fixe','tel_portable','image','clients.created_at','clients.updated_at'));
        $ssData = Datatables::of($clients);
        $ssData = $ssData->editColumn('nom','
                        <img class="img-circle" src="/images/{{$image}}" style="width: 50px;height:50px;"/>
                        {{$nom}} {{$prenom}}');
        $ssData = $ssData->addColumn('butts','
                        <p data-placement="top" data-toggle="tooltip" title="Edit">
                            <button class="btn btn-warning btn-xs editButton" data-title="Edit" data-toggle="modal" data-target="#edit" data-id="{{$id}}" >
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button class="btn btn-danger btn-xs deleteButton" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="{{$id}}" >
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                            <a class="btn btn-default btn-xs" href="/client/profile?id={{$id}}" >
                                <span class="glyphicon glyphicon-user"></span>
                            </a>
                        </p>
                    ');
        return $ssData->make(true);
    }

    public function queryArchiveClients(Request $request){
        $clients = Client::onlyTrashed()->join('adresses','clients.adresse_id','=','adresses.id')->select(array('clients.id','nom','prenom','email','adresse','tel_fixe','tel_portable','image','clients.created_at','clients.updated_at'));
        $ssData = Datatables::of($clients);
        $ssData = $ssData->editColumn('nom','
                        <img class="img-circle" src="/images/{{$image}}" style="width: 50px;height:50px;"/>
                        {{$nom}} {{$prenom}}');
        $ssData = $ssData->addColumn('butts','
                        <p data-placement="top" data-toggle="tooltip" title="Edit">
                            <button class="btn btn-success btn-xs restoreButton" data-title="Restore" data-toggle="modal" data-target="#restore" data-id="{{$id}}" >
                                <span class="glyphicon glyphicon-refresh"></span>
                            </button>
                            <a class="btn btn-default btn-xs" href="/client/profile?id={{$id}}" >
                                <span class="glyphicon glyphicon-user"></span>
                            </a>
                        </p>');
        return $ssData->make(true);
    }

    public function archiveClients(){
        return view('client.clientArchive');
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
        try {
            DB::beginTransaction();
            ClientTools::updateClient(null,$connectedUser, $request);
            AdresseTools::updateAdresse($connectedUser,$request);
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $trace = new Trace();
            $trace->operation = "Modification";
            $trace->type = 'Client';
            $trace->resultat = false;
            $trace->user()->associate($connectedUser);
            $trace->save();
            DB::commit();
        }
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
