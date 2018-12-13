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

    public function incidents(){
        return $this->hasMany('App\Incident');
    }

    public function resolves(){
        return $this->hasMany('App\Resolve');
    }
}
