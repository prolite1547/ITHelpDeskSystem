<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
    ];


    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function Tickets(){
        return $this->hasMany('App\Ticket','status','id');
    }

    public function resolves(){
        return $this->hasMany('App\Resolve');
    }
}
