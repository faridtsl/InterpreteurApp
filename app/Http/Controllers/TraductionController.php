<?php

namespace App\Http\Controllers;

use App\Tools\DemandeTools;
use App\Tools\InterpreteurTools;
use App\Tools\TraductionTools;
use Illuminate\Http\Request;

use App\Http\Requests;

class TraductionController extends Controller{


    public function getTraductions(Request $request){
        if($request['idI'] != null)
            $traductions = TraductionTools::getTraductionsByInterpreteur($request['idI']);
        else
            $traductions = TraductionTools::getTraductionsByDemande($request['idD']);
        return response($traductions);
    }

    public function deleteTraduction(Request $request){
        if($request['idI'] != null)
            return $this->deleteTraductionByInterpreteur($request);
        else
            return $this->deleteTraductionByDemande($request);
    }

    public function deleteTraductionByInterpreteur(Request $request){
        $traduction = TraductionTools::getTraductionById($request['idT']);
        $interpreteur = InterpreteurTools::getInterpreteur($request['idI']);
        $interpreteur->traductions()->detach($traduction->id);
        return $this->getTraductions($request['idI']);
    }

    public function deleteTraductionByDemande(Request $request){
        $traduction = TraductionTools::getTraductionById($request['idT']);
        $demande = DemandeTools::getDemande($request['idD']);
        $demande->traductions()->detach($traduction->id);
        return $this->getTraductions($request);
    }

}
