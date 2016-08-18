<?php

namespace App\Http\Controllers;

use App\Tools\DemandeTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
use App\Trace;
use Illuminate\Http\Request;

use App\Http\Requests;

class GeneralController extends Controller{

    public function showRemainders(){
        $demandes = DemandeTools::getAllDemandes();
        $devis = DevisTools::getAllDevis();
        $factures = FactureTools::getFactures();
        //dd($factures);
        $factures = $factures->filter(function($fact){return ($fact->fini==false) && \App\Tools\FactureTools::tempsRestant($fact) >= env('REMAINDER_DELAI_FACTURE','0');});
        return view('remainder',['demandes'=>$demandes,'devis'=>$devis,'factures'=>$factures]);
    }

    public function showTraces(){
        $traces = Trace::all();
        return view('trace',['traces'=>$traces]);
    }

}
