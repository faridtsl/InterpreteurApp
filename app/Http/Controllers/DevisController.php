<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Devi;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DevisTools;
use App\Tools\InterpreteurTools;
use App\Tools\ServiceTools;
use App\User;
use Illuminate\Http\Request;
use App\Tools\MailTools;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller{

    public function show(Request $request){
        $demande = Demande::find($request['id']);
        $interpreteurs = InterpreteurTools::getAllInterpreteurs();
        return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs]);
    }

    public function store(Request $request){
        $connectedUser = Auth::user();
        $demande = Demande::find($request['demande_id']);
        $client = ClientTools::getClient($demande->client_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $interpreteurs = InterpreteurTools::getAllInterpreteurs();
        try {
            DB::beginTransaction();
            $devis = DevisTools::addDevis($request,$connectedUser);
            $services = ServiceTools::getServices($devis->id);
            MailTools::sendMail('Devis créée','devis','creadis.test@gmail.com',$client->email,[],['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis],'public/css/style_df.css');
            DB::commit();
            return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs,'message'=>'Devis ajouté avec success']);
        }catch(\Exception $e){
            DB::rollback();
        }
        $errors = ['Une erreur s\'est survenu veuillez reverifier vos données'];
        return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs])->withErrors($errors);
    }

    public function showDevis(Request $request){
        $devis = Devi::all();
        return view('devis.devisShow',['devis'=>$devis]);
    }

    public function resendDevis(Request $request){
        $devis = Devi::find($request['id']);
        DevisTools::sendDevisMail($devis);
    }

    public function viewDevis(Request $request){
        $devis = Devi::find($request['id']);
        $demande = Demande::find($devis->demande_id);
        $client = ClientTools::getClient($demande->client_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $services = ServiceTools::getServices($devis->id);
        return view('emails.devis',['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis]);
    }

}
