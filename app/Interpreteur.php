<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interpreteur extends Model{

    public function adresse(){
        return $this->belongsTo(Adresse::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function traductions(){
        return $this->belongsToMany(Traduction::class,'interpreteurs_traductions');
    }

}
