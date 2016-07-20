<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Langue extends Model{

    public function source(){
        return $this->belongsToMany(Langue::class,'traductions','source','cible');
    }

    public function cible(){
        return $this->belongsToMany(Langue::class,'traductions','cible','source');
    }

}
