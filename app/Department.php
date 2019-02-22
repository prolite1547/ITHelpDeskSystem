<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'department'
    ];

    public function setDepartmentAttribute($value){
        return $this->attributes['department'] = cleanInputs($value);
    }
}
