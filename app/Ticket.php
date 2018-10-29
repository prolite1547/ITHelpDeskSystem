<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'type',
        'incident_id',
        'assignee',
        'date_closed',
        'resolved_by',
    ];

public function incident(){
    return $this->belongsTo('App\Incident');
}
}
