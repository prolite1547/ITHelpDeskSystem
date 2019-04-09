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

    public function loggedBy(){
        return $this->belongsTo('App\User','user_id');
    }







}
