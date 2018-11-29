<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'type',
        'incident_id',
        'assignee',
        'date_closed',
        'resolved_by',
        'priority',
        'status'
    ];

    protected $dates = ['deleted_at'];

public function incident(){
    return $this->belongsTo('App\Incident');
}

public function assigneeRelation(){
    return $this->belongsTo('App\User','assignee')->withDefault(['name' => 'none']);
}

public function resolvedBy(){
    return $this->belongsTo('App\User','resolved_by')->withDefault(['name' => 'none']);
}

public function priorityRelation(){
    return $this->belongsTo('App\Category','priority');
}

public function statusRelation(){
    return $this->belongsTo('App\Category','status');
}

public function typeRelation(){
    return $this->belongsTo('App\Category','type');
}

public function getFileDirectoryFolder()
{

    $date = str_replace(':','',preg_replace('/[-,\s]/','_',$this->created_at));

    return "{$date}_{$this->id}";
}

}
