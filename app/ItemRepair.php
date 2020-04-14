<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemRepair extends Model
{
     protected $fillable = [
         'workstation_id',
         'ticket_id',
         'reason',
         'item_id',
         'date_repaired'
     ];

     public function item(){
          return $this->belongsTo('App\Item', 'item_id', 'id');
     }
}
