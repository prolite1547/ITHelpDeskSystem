<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'type',
        'incident_id',
        'assignee',
        'priority',
        'status',
        'expiration'
    ];

    protected $dates = ['deleted_at','created_at','updated_at','expiration'];



public function incident(){
    return $this->belongsTo('App\Incident');
}

public function assigneeRelation(){
    return $this->belongsTo('App\User','assignee')->withDefault(['name' => 'none']);
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

public function ticketMessages(){
    return $this->hasMany('App\Message')->latest('created_at');
}

public function resolve(){
    return $this->hasOne('App\Resolve');
}

public function getFileDirectoryFolder()
{

    $date = str_replace(':','',preg_replace('/[-,\s]/','_',$this->created_at));

    return "{$date}_{$this->id}";
}

public function getExpirationAttribute($value){
        $now = Carbon::now();
        if( $now > $value){
            return 'Expired';
        }else {
            return Carbon::parse($value)->diffForHumans($now);
        }

}

}
