<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'position',
        'department_id'
    ];

    public function setPositionAttribute($value){
        return $this->attributes['position'] = cleanInputs($value);
    }

    public function department() {
        return $this->belongsTo('App\Department');
    }

}
