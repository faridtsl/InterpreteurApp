<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interpreteur extends Model{

    public function adresse(){
        return $this->hasOne(Adresse::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }

}
