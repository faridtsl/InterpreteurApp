<?php

namespace App\Http\Controllers;

use App\Tools\AdresseTools;
use App\Tools\InterpreteurTools;
use App\Tools\LangueTools;
use App\Tools\TraductionTools;
use Illuminate\Http\Request;

use App\Http\Requests\InterpreteurRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class InterpreteurController extends Controller{

    public function show(){
        $langues = LangueTools::getAllLangues();
        return view('interpreteur.interpreteurAdd', ['langues' => $langues]);
    }

    public function store(InterpreteurRequest $request){
        $langues = LangueTools::getAllLangues();
        $adresse = AdresseTools::addAdresse($request);
        $connectedUser = Auth::user();
        $image = Input::file('image');
        $imgName = '';
        if($image == null){
            $imgName = 'unknown.jpg';
        }else {
            $imgName = $this->getName($image, $request);
            Input::file('image')->move(storage_path() . '/img', $imgName);
        }
        $request['imageName'] = $imgName;
        $interpreteur = InterpreteurTools::addInterpreteur($adresse,$connectedUser,$request);
        $langs_init = $request['langue_src'];
        $langs_dest = $request['langue_dest'];
        foreach ($langs_init as $index => $value){
            $src = LangueTools::getLangue($value);
            $dst = LangueTools::getLangue($langs_dest[$index]);
            $traduction = TraductionTools::getTraduction($src,$dst);
            InterpreteurTools::addTraduction($interpreteur,$traduction);
        }
        return view('interpreteur.interpreteurAdd',['message'=>'Interpreteur ajouté avec success!','img'=>$imgName,'langues' => $langues,'interpreteur'=>$interpreteur]);
    }

    private function getName($image,$request){
        return $request['nom'].'_'.$request['prenom'].rand(11111,99999).'.'.$image->getClientOriginalExtension();
    }

    public function getImage($img){
        return Storage::disk('img')->get($img);
    }

    public function showInterpreteurs(){
        $interpreteurs = InterpreteurTools::getAllInterpreteurs();
        return view('interpreteur.interpreteursShow',['interpreteurs'=>$interpreteurs]);
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
        InterpreteurTools::updateInterpreteur($connectedUser,$request);
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