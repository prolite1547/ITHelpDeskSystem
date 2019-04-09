<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualPosition extends Model
{
    protected $table = 'm_positions';


    public function caller(){
        return $this->morphOne(\App\Caller::class,'position');
    }
}
