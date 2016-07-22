<?php

namespace App\Http\Controllers;

use App\Tools\LangueTools;
use Illuminate\Http\Request;

use App\Http\Requests;

class LangueController extends Controller{

    public function show(){
        return view('langue');
    }

    public function store(Request $r){
        LangueTools::addLangue($r['abreviation'],$r['nom']);
        return view('langue',['message'=>'Langue ajoutée avec success']);
    }

}
