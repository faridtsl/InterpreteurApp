<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traduction extends Model{

    public function interpreteurs(){
        return $this->belongsToMany(Interpreteur::class,'interpreteurs_traductions');
    }

    public function demandes(){
        return $this->belongsToMany(Demande::class,'demandes_tradutions');
    }

    public function langue_cible(){
        return $this->belongsTo(Langue::class,'cible');
    }

    public function langue_source(){
        return $this->belongsTo(Langue::class,'source');
    }

}
