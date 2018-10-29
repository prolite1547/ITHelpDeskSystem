<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
        'group'
    ];

    public function group(){

        return $this->belongsTo('App\CategoryGroup','group',' id');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
