<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VpnId extends Model
{
    protected $fillable = [

    ];

    public function vpn(){
        return $this->hasMany('App\Vpn', 'vpn_num_id');
    }
}
