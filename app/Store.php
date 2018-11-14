<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'store_name'
    ];


    public function contactNumbers(){
        return $this->hasMany('App\Contact','store_id','id');
    }
}
