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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function traduction(){
        return $this->belongsTo(Traduction::class);
    }

    public function etat(){
        return $this->belongsTo(Etat::class);
    }

}
