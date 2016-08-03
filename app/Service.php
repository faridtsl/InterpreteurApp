<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model{
    public function devis(){
        return $this->belongsTo(Devi::class,'devi_id');
    }
}
