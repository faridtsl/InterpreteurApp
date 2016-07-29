<?php

namespace App\Http\Controllers;

use App\Tools\AdresseTools;
use App\Tools\ImageTools;
use App\Tools\InterpreteurTools;
use App\Tools\LangueTools;
use App\Tools\TraductionTools;
use Illuminate\Http\Request;

use App\Http\Requests\InterpreteurRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class InterpreteurController extends Controller{

    public function show(){
        $langues = LangueTools::getAllLangues();
        return view('interpreteur.interpreteurAdd', ['langues' => $langues]);
    }

    public function store(InterpreteurRequest $request){

        $langues = LangueTools::getAllLangues();
        try {
            DB::beginTransaction();
            $adresse = AdresseTools::addAdresse($request);
            $connectedUser = Auth::user();
            $image = Input::file('image');
            $imgName = '';
            if ($image == null) {
                $imgName = 'unknown.jpg';
            } else {
                $imgName = ImageTools::getName($image, $request);
                Input::file('image')->move(storage_path() . '/img', $imgName);
            }
            $request['imageName'] = $imgName;
            $interpreteur = InterpreteurTools::addInterpreteur($adresse, $connectedUser, $request);
            InterpreteurTools::addTraductions($interpreteur,$request);
            DB::commit();
            return view('interpreteur.interpreteurAdd', ['message' => 'Interpreteur ajouté avec success!', 'img' => $imgName, 'langues' => $langues, 'interpreteur' => $interpreteur]);
        }catch(\Exception $e){
            DB::rollback();
        }
        $errors = ['Veuillez remplire toutes les correspondances src->dest'];
        return view('interpreteur.interpreteurAdd', ['langues' => $langues])->withErrors($errors);
    }

    public function showInterpreteurs(){
        $langues = LangueTools::getAllLangues();
        $interpreteurs = InterpreteurTools::getAllInterpreteurs();
        return view('interpreteur.interpreteursShow',['interpreteurs'=>$interpreteurs,'langues'=>$langues]);
    }

    public function archiveInterpreteurs(){
        $interpreteursArchive = InterpreteurTools::getArchiveInterpreteurs();
        return view('interpreteur.interpreteurArchive',['interpreteurs'=>$interpreteursArchive]);
    }

    public function showInterpreteur($id){
        return response(InterpreteurTools::getInterpreteur($id));
    }


    public function updateInterpreteur(Request $request){
        $connectedUser = Auth::user();
        $interpreteur = InterpreteurTools::getInterpreteur($request['id']);
        $image = Input::file('image');
        if ($image == null) {
            $imgName = $interpreteur->image;
        } else {
            $imgName = $interpreteur->image;
            if($imgName == 'unknown.jpg')
                $imgName = ImageTools::getName($image, $request);
            Input::file('image')->move(storage_path() . '/img', $imgName);
        }
        $request['imageName'] = $imgName;

        $interpreteur = InterpreteurTools::updateInterpreteur($connectedUser,$request);
        AdresseTools::updateAdresse($connectedUser,$request);
        InterpreteurTools::addTraductions($interpreteur,$request);
        return redirect('interpreteur/list');
    }

    public function deleteInterpreteur(Request $request){
        $connectedUser = Auth::user();
        InterpreteurTools::deleteInterpreteur($connectedUser,$request['id']);
        return redirect('interpreteur/list');
    }

    public function restoreInterpreteur(Request $request){
        $connectedUser = Auth::user();
        InterpreteurTools::restoreInterpreteur($connectedUser,$request['id']);
        return redirect('interpreteur/archive');
    }

}