<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caller extends Model
{
    protected $fillable = [
        'fName',
        'mName',
        'lName',
        'store_id',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        $middle_name = $this->mName;

        return ucfirst($this->fName) . ' ' . $middle_name[0] .'.' . ' ' . ucfirst($this->lName);
    }

    public function users(){
        return $this->belongsToMany('App\User','calls');
    }

    public  function call(){
        return $this->hasMany('App\Call','caller_id','id');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }
}
