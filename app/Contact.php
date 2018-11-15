<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'number',
        'store_id',
    ];

    public function store(){
        return $this->belongsTo('App\Store','store_id','id');
    }

    public function call(){
        return $this->hasMany('App\Call','contact_id','id');
    }
}
