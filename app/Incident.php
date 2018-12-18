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
        'drd',
    ];

    public function call(){
        return $this->belongsTo('App\Call');
    }

    public function ticket(){
        return $this->hasOne('App\Ticket');
    }

    public function categoryRelation(){
        return $this->belongsTo('App\Category','category')->withDefault(['name' => 'none']);
    }

    public function catARelation(){
        return $this->belongsTo('App\Category','catA')->withDefault(['name' => 'none']);;
    }

    public function catBRelation(){
        return $this->belongsTo('App\Category','catB')->withDefault(['name' => 'none','id' => 'none']);;
    }

    public function getFiles(){
        return $this->hasMany('App\File');
    }


}
