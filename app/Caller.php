<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caller extends Model
{
    protected $fillable = [
        'name',
        'store_id',
    ];


    public function users(){
        return $this->belongsToMany('App\User','calls');
    }

    public  function call(){
        return $this->hasMany('App\Call','caller_id','id');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }
}
