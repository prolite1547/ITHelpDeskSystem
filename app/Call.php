<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
    'caller_id',
    'user_id',
    'store_id',
    ];


    public function incident(){
        return $this->hasOne('App\Incident');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function callerRelation(){
        return $this->belongsTo('App\Caller','caller_id','id');
    }

    public function loggedBy(){
        return $this->belongsTo('App\User','user_id');
    }






}
