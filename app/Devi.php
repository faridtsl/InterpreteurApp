<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devi extends Model{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function demande(){
        return $this->belongsTo(Demande::class);
    }

    public function interpreteur(){
        return $this->belongsTo(Interpreteur::class);
    }

    public function etat(){
        return $this->belongsTo(DevisEtat::class);
    }

    public function traces(){
        return $this->morphMany(Trace::class,'concerned');
    }

}
