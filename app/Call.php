<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
    'caller_id',
    'user_id',
    'contact_id',
    ];


    public function incident(){
        return $this->hasOne('App\Incident');
    }

    public function contact(){
        return $this->belongsTo('App\Contact');
    }

    public function callerRelation(){
        return $this->belongsTo('App\User','caller_id','id');
    }

    public function loggedBy(){
        return $this->belongsTo('App\User','user_id');
    }







}
