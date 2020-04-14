<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Canvass extends Model
{   
    use SoftDeletes;
    protected $table = "canvasses";
    protected $fillable = [
        'ticket_id',
        'c_storename',
        'c_serial_no',
        'c_itemdesc',
        'c_qty',
        'c_price',
        'item_id',
        'is_approved',
        'approval_id',
        'app_code',
        'purchase_date',
        'date_installed'
    ];

    public function item(){
        return $this->belongsTo('App\Item', 'item_id', 'id');
    }
}
