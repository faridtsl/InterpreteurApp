<?php

namespace App\Http\Controllers;

use App\Tools\EtatTools;
use Illuminate\Http\Request;

use App\Http\Requests;

class EtatController extends Controller{

    public function show(){
        return view('etat');
    }

    public function store(Request $r){
        EtatTools::addEtat($r['lib']);
        return view('etat',['message'=>'Etat ajouté avec success']);
    }

}
