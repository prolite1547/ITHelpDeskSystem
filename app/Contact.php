<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'number',
        'store_id',
        'type_id',
        'telco_id',
        'account_id'
    ];

    public function store(){
        return $this->belongsTo('App\Store','store_id','id');
    }

    public function call(){
        return $this->hasMany('App\Call','contact_id','id');
    }

    public function account(){
        return $this->belongsTo('App\TelAccount', 'account_id');
    }

    public function telco(){
        return $this->belongsTo('App\Telco', 'telco_id');
    }
}
