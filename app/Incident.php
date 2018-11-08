<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'call_id',
        'subject',
        'details',
        'category',
        'catA',
        'catB',
        'catC',
        'expiration',
        'files',
        'drd',
    ];

    public function call(){
        return $this->belongsTo('App\Call');
    }

    public function ticket(){
        return $this->hasOne('App\Ticket');
    }

    public function categoryRelation(){
        return $this->belongsTo('App\Category','category');
    }


}
