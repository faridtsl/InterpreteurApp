<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adresse extends Model{

    public function interpreteurs(){
        return $this->belongsToMany(Interpreteur::class);
    }

    public function clients(){
        return $this->belongsToMany(Client::class);
    }

}
