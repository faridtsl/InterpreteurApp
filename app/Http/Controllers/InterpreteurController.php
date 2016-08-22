<?php

namespace App\Http\Controllers;

use App\Tools\AdresseTools;
use App\Tools\DevisTools;
use App\Tools\FactureTools;
use App\Tools\ImageTools;
use App\Tools\InterpreteurTools;
use App\Tools\LangueTools;
use App\Tools\TraductionTools;
use App\Trace;
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
        $connectedUser = Auth::user();
        $langues = LangueTools::getAllLangues();
        try {
            DB::beginTransaction();
            $adresse = AdresseTools::addAdresse($request);
            $image = Input::file('image');
            $imgName = '';
            if ($image == null) {
                $imgName = 'unknown.jpg';
            } else {
                $imgName = ImageTools::getName($image, $request);
                Input::file('image')->move(storage_path() . '/img', $imgName);
            }
            $cv = Input::file('cv');
            if($cv != null){
                $cvName = ImageTools::getName($cv,$request);
                Input::file('cv')->move(storage_path().'/cv',$cvName);
                $request['cvName'] = $cvName;
            }else{
                $request['cvName'] = 'NULL';
            }
            $cv_anonyme = Input::file('cv_anonyme');
            if($cv_anonyme != null){
                $cvName = ImageTools::getName($cv_anonyme,$request);
                Input::file('cv_anonyme')->move(storage_path().'/cv_anonyme',$cvName);
                $request['cvAnonymeName'] = $cvName;
            }else{
                $request['cvAnonymeName'] = 'NULL';
            }
            $request['imageName'] = $imgName;
            $interpreteur = InterpreteurTools::addInterpreteur($adresse, $connectedUser, $request);
            InterpreteurTools::addTraductions($interpreteur,$request);
            DB::commit();
            return view('interpreteur.interpreteurAdd', ['message' => 'Interpreteur ajouté avec success!', 'img' => $imgName, 'langues' => $langues, 'interpreteur' => $interpreteur]);
        }catch(\Exception $e){
            DB::rollback();
            $trace = new Trace();
            $trace->operation = "Creation";
            $trace->type = 'Interpreteur';
            $trace->resultat = false;
            $trace->user()->associate($connectedUser);
            $trace->save();
            DB::commit();
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

    public function showInterpreteur(Request $request){
        $id = $request['id'];
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
        $cv = Input::file('cv');
        if($cv != null){
            $cvName = ImageTools::getName($cv,$request);
            Input::file('cv')->move(storage_path().'/cv',$cvName);
            $request['cvName'] = $cvName;
        }
        $cv_anonyme = Input::file('cv_anonyme');
        if($cv_anonyme != null){
            $cvName = ImageTools::getName($cv_anonyme,$request);
            Input::file('cv_anonyme')->move(storage_path().'/cv_anonyme',$cvName);
            $request['cvAnonymeName'] = $cvName;
        }

        $interpreteur = InterpreteurTools::updateInterpreteur($connectedUser,$request);
        AdresseTools::updateAdresse($connectedUser,$request);
        InterpreteurTools::addTraductions($interpreteur,$request);
        return redirect()->back();
    }

    public function deleteInterpreteur(Request $request){
        $connectedUser = Auth::user();
        $errors = [];
        if(InterpreteurTools::canBeDeleted($request['id'])) {
            InterpreteurTools::deleteInterpreteur($connectedUser, $request['id']);
        }else{
            array_push($errors,'L\'interpreteur a des devis en cours/Factures non payées');
        }
        return redirect()->back()->withErrors($errors);
    }

    public function restoreInterpreteur(Request $request){
        $connectedUser = Auth::user();
        InterpreteurTools::restoreInterpreteur($connectedUser,$request['id']);
        return redirect('interpreteur/archive');
    }

    public function showProfileInterpreteur(Request $request){
        $interp = InterpreteurTools::getInterpreteur($request['id']);
        $devs = DevisTools::getDevisByInterp($interp->id);
        $langues = LangueTools::getAllLangues();
        $factures = [];
        foreach ($devs as $dev) {
            $fact = FactureTools::getFactureByDevis($dev->id);
            if ($fact != null) array_push($factures, $fact);
        }
        return view('interpreteur.profileInterpreteur',['interpreteur'=>$interp,'factures'=>$factures,'devis'=>$devs,'langues'=>$langues]);
    }

    public function showArchiveProfileInterpreteur(Request $request){
        $interp = InterpreteurTools::getInterpreteur($request['id']);
        $devs = DevisTools::getArchiveByInterp($interp->id);
        $factures = [];
        foreach ($devs as $dev) {
            $fact = FactureTools::getFactureByDevis($dev->id);
            if ($fact != null && $fact->trashed()) array_push($factures, $fact);
        }
        return view('interpreteur.profileArchiveInterpreteur',['interpreteur'=>$interp,'factures'=>$factures,'devis'=>$devs]);
    }

    private function getDownload($fileName,$downName){
        //PDF file is stored under project/public/download/info.pdf
        $file= storage_path().$fileName;

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file, $downName , $headers);
    }

    public function getCvAnonyme(Request $request){
        if($request['id'] == null) return redirect()->back();
        $interp = InterpreteurTools::getInterpreteur($request['id']);
        return $this->getDownload('/cv_anonyme/'.$interp->cv_anonyme,'cv_anonyme.pdf');
    }

    public function getCv(Request $request){
        if($request['id'] == null) return redirect()->back();
        $interp = InterpreteurTools::getInterpreteur($request['id']);
        return $this->getDownload('/cv/'.$interp->cv,$interp->nom.'_'.$interp->prenom.'_CV.pdf');
    }

}