<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adresse extends Model{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function interpreteurs(){
        return $this->belongsToMany(Interpreteur::class);
    }

    public function clients(){
        return $this->belongsToMany(Client::class);
    }

}
