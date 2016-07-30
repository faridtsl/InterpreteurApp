<?php

namespace App\Http\Controllers;

use App\Tools\InterpreteurTools;
use App\Tools\TraductionTools;
use Illuminate\Http\Request;

use App\Http\Requests;

class TraductionController extends Controller{


    public function getTraductions($id){
        $traductions = TraductionTools::getTraductionsByInterpreteur($id);
        return response($traductions);
    }

    public function deleteTraduction(Request $request){
        $traduction = TraductionTools::getTraductionById($request['idT']);
        $interpreteur = InterpreteurTools::getInterpreteur($request['idI']);
        $interpreteur->traductions()->detach($traduction->id);
        return $this->getTraductions($request['idI']);
    }

}
