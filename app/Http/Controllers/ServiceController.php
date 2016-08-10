<?php

namespace App\Http\Controllers;

use App\Service;
use App\Tools\DevisTools;
use App\Tools\ServiceTools;
use Illuminate\Http\Request;

use App\Http\Requests;

class ServiceController extends Controller{

    public function deleteService(Request $request){
        $service = Service::find($request['id']);
        $devis = DevisTools::getDevisById($service->devi_id);
        $devis->total = DevisTools::getTotal($devis->id);
        $devis->save();
        $service->delete();
        return redirect()->back();
    }

}
