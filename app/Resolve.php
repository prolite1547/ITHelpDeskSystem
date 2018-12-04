<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resolve extends Model
{

    protected $fillable = [
        'cause',
        'resolution',
        'recommendation',
        'res_category',
        'resolved_by',
        'ticket_id',
    ];

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }

    public function resolvedBy(){
        return $this->belongsTo('App\User','resolved_by')->withDefault(['name' => 'none']);
    }
}
