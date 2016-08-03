<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Tools\DevisTools;
use App\Tools\InterpreteurTools;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller{

    public function show(Request $request){
        $demande = Demande::find($request['id']);
        $interpreteurs = InterpreteurTools::getAllInterpreteurs();
        return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs]);
    }

    public function store(Request $request){
        $connectedUser = Auth::user();
        $demande = Demande::find($request['demande_id']);
        $interpreteurs = InterpreteurTools::getAllInterpreteurs();
        try {
            DB::beginTransaction();
            DevisTools::addDevis($request,$connectedUser);
            DB::commit();
            return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs,'message'=>'Devis ajouté avec success']);
        }catch(\Exception $e){
            DB::rollback();
        }
        $errors = ['Une erreur s\'est survenu veuillez reverifier vos données'];
        return view('devis.devisAdd',['demande'=>$demande,'interpreteurs'=>$interpreteurs])->withErrors($errors);
    }

}
