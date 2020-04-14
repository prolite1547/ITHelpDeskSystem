<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VpnCategory extends Model
{
   protected $fillable = [

   ];

   public function vpn(){
       return $this->hasMany('App\Vpn', 'vpn_cat_id');
   }
}
