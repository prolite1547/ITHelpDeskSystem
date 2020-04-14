<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{   
    protected $table = "items";
    protected $fillable = [
        'workstation_id',
        'serial_no',
        'item_description',
        'itemcateg_id',
        'no_repaired',
        'no_replace',
        'date_used'
    ];

    public function workstation(){
        return $this->belongsTo('App\Workstation');
    }
}
