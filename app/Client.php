<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function traces(){
        return $this->morphMany(Trace::class,'concerned');
    }

    public function adresse(){
        return $this->belongsTo(Adresse::class);
    }

}
