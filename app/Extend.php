<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extend extends Model
{
    protected $fillable = [
        'ticket_id',
        'duration',
        'details',
        'extended_by'
    ];

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }
}
