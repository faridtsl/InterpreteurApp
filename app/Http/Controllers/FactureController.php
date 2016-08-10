<?php

namespace App\Http\Controllers;

use App\Facture;
use Illuminate\Http\Request;

use App\Http\Requests;

class FactureController extends Controller{


    public function showFactures(Request $request){
        $factures = Facture::all();
        return view('facture.factureShow',['factures'=>$factures]);
    }

}
