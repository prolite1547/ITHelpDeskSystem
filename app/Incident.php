<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'call_id'
    ];

    public function call(){
        return $this->hasOne('App\Call');
    }

    public function ticket(){
        return $this->hasOne('App\Ticket');
    }
}
