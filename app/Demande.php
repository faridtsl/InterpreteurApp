<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demande extends Model{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function adresse(){
        return $this->belongsTo(Adresse::class);
    }

}
