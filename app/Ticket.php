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

public function assigneeRelation(){
    return $this->belongsTo('App\User','assignee');
}

public function priorityRelation(){
    return $this->belongsTo('App\Category','priority');
}

public function statusRelation(){
    return $this->belongsTo('App\Category','status');
}
}
