<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
        'order',
        'group',
        'value'
    ];

    public function group(){

        return $this->belongsTo('App\CategoryGroup','group',' id');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function openIncidents(){
        return $this->hasMany('App\Incident','');
    }

    public function Tickets(){
        return $this->hasMany('App\Ticket','status','id');
    }

    public function resolves(){
        return $this->hasMany('App\Resolve');
    }
}
