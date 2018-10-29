<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
    'caller_id',
    'user_id',
    'subject',
    'details',
    'category',
    'catA',
    'catB',
    'catC',
    'priority',
    'expiration',
    'atatus',
    'files',
    'drd',
    ];


    public function incident(){

        return $this->hasOne('App\Incident');
    }
}
