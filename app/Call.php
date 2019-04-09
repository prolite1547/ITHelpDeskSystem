<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
    'caller_id',
    'caller_type',
    'user_id',
    'contact_id',
    ];


    public function incident(){
        return $this->morphOne('App\Incident','incident');
    }

    public function contact(){
        return $this->belongsTo('App\Contact');
    }

    public function caller(){
        return $this->morphTo();
    }

    public function callerRelationOld(){
        return $this->belongsTo('App\Caller','caller_id','id');
    }

    public function loggedBy(){
        return $this->belongsTo('App\User','user_id');
    }







}
