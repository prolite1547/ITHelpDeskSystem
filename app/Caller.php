<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caller extends Model
{
    protected $fillable = [
        'fName',
        'mName',
        'lName',
        'position',
    ];

    protected $appends = ['full_name'];


    public function setfNameAttribute($value){
        return $this->attributes['fName'] = cleanInputs($value);
    }

    public function setmNameAttribute($value){
        return $this->attributes['mName'] = cleanInputs($value);
    }

    public function setlNameAttribute($value){
        return $this->attributes['lName'] = cleanInputs($value);
    }

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

    public function positionData(){
        return $this->belongsTo('App\Position','position');
    }
}
