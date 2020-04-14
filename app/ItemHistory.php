<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ItemHistory extends Model
{   
    use SoftDeletes;
    protected $table = "item_histories";
    protected $fillable = [
        'ticket_id',
        'item_id',
        'serial_no_old',
        'item_desc_old',
        'action',
        'serial_no_new',
        'item_replaced',
        'user_id'
    ];

    public function ticket(){
        return $this->belongsTo('App\Ticket', 'ticket_id', 'id');
    }

    public function item(){
        return $this->belongsTo('App\Item', 'item_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
