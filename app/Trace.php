<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trace extends Model{

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function concerned(){
        return $this->morphTo();
    }

}
