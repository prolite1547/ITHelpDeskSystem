<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'store_name'
    ];

//    public function tickets(){
//        return $this->hasMany('App\Ticket','store','id');
//    }

    public function callers(){
        return $this->hasMany('App\Caller');
    }

    public function contacts(){
        return $this->hasMany('App\Contact');
    }

    public function setStoreNameAttribute($value){
        return $this->attributes['store_name'] = cleanInputs($value);
    }

}
