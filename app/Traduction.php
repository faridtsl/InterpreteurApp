<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traduction extends Model{

    public function interpreteurs(){
        return $this->belongsToMany(Interpreteur::class,'interpreteurs_tradutions');
    }

    public function demandes(){
        return $this->belongsToMany(Demande::class,'demandes_tradutions');
    }

}
