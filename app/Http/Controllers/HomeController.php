<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Http\Requests;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\MailTools;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demande = Demande::find(1);
        $client = ClientTools::getClient($demande->client_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        MailTools::sendMail('Demande créée','createDemande','faridkaiba@gmail.com','faridkaiba@gmail.com',[],['client'=>$client,'demande'=>$demande,'adresse'=>$adresse],'public/css/mailStyle.css');
        return view('emails.createDemande',['client'=>$client,'demande'=>$demande,'adresse'=>$adresse]);
    }
}
