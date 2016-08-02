<?php

namespace App\Http\Controllers;

use App\Interpreteur;
use App\Tools\AdresseTools;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdresseController extends Controller{


    public function showUpdate($id){
        $interpreteur = Interpreteur::where('adresse_id',$id)->get()->first();
        return view('adresseUpdate',['id'=>$id,'interpreteur'=>$interpreteur]);
    }

    public function get($id){
        return response(AdresseTools::getAdresse($id));
    }

    public function storeUpdate(Request $request){
        $connectedUser = Auth::user();
        $adresse = AdresseTools::updateAdresse($connectedUser,$request);
        return response($adresse);
    }

}
