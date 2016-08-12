<?php

namespace App\Http\Controllers;

use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
use Illuminate\Http\Request;

use App\Http\Requests;

class GeneralController extends Controller{

    public function showRemainders(){
        $demandes = DemandeTools::getAllDemandes();
        $devis = DevisTools::getAllDevis();
        $factures = FactureTools::getFactures();
        return view('remainder',['demandes'=>$demandes,'devis'=>$devis,'factures'=>$factures]);
    }

}
