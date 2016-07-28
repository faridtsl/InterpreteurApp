<?php

namespace App\Http\Controllers;

use App\Tools\AdresseTools;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdresseController extends Controller{


    public function get($id){
        return response(AdresseTools::getAdresse($id));
    }

}
