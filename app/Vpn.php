<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vpn extends Model
{
    protected $fillable = [

    ];

    public function vpnId(){
        return $this->belongsTo('App\VpnId', 'vpn_num_id');
    }

    public function vpnCategory(){
        return $this->belongsTo('App\VpnCategory', 'vpn_cat_id');
    }

    public function store(){
        return $this->belongsTo('App\Store', 'store_id');
    }
}
