<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workstation extends Model
{   
    use SoftDeletes;
    protected $table = "workstations";
    protected $fillable = [
        'ws_description',
        'store_id',
        'department_id'
    ];

    public function items(){
        return $this->hasMany('App\Item');
    }

    public function store(){
        return $this->belongsTo('App\Store', 'store_id', 'id');
    }

    public function department(){
        return $this->belongsTo('App\Department', 'department_id', 'id');
    }
}
