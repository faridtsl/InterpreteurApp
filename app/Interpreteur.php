<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interpreteur extends Model{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
