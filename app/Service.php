<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model{


    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function devis(){
        return $this->belongsTo(Devi::class,'devi_id');
    }
    public function traces(){
        return $this->morphMany(Trace::class,'concerned');
    }
}
