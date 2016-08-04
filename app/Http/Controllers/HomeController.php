<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Devi;
use App\Http\Requests;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\MailTools;
use App\Tools\ServiceTools;
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
        $devis = Devi::find(9);
        $demande = Demande::find($devis->demande_id);
        $client = ClientTools::getClient($demande->client_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $services = ServiceTools::getServices($devis->id);
        MailTools::sendMail('Devis créée','devis','faridkaiba@gmail.com','faridkaiba@gmail.com',[],['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis],'public/css/style_df.css');
        return view('emails.devis',['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis]);
    }
}
