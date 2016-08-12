<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Devi;
use App\Http\Requests;
use App\Tools\AdresseTools;
use App\Tools\ClientTools;
use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
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
    public function index(){
        $client = ClientTools::getClient(1);
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
        return view('home',['client'=>$client,'demandes'=>$demandes,'factures'=>$factures,'devis'=>$devis]);

        $devis = Devi::find(9);
        $demande = Demande::find($devis->demande_id);
        $client = ClientTools::getClient($demande->client_id);
        $adresse = AdresseTools::getAdresse($demande->adresse_id);
        $services = ServiceTools::getServices($devis->id);
        MailTools::sendMail('Devis créée','devis','faridkaiba@gmail.com','faridkaiba@gmail.com',[],['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis],'public/css/style_df.css');
        return view('emails.devis',['services'=>$services,'client'=>$client,'demande'=>$demande,'adresse'=>$adresse,'devis'=>$devis]);
    }
}
