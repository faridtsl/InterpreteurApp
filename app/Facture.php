<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facture extends Model{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function devis(){
        return $this->belongsTo(Devi::class,'devi_id');
    }

}
