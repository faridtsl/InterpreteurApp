<?php

namespace App\Http\Controllers;

use App\Interpreteur;
use App\Tools\AdresseTools;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdresseController extends Controller{


    public function showUpdate($id){
        $interpreteur = Interpreteur::where('adresse_id',$id)->get()->first();
        return view('adresseUpdate',['id'=>$id,'interpreteur'=>$interpreteur]);
    }

    public function get($id){
        return response(AdresseTools::getAdresse($id));
    }

}
