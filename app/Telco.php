<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telco extends Model
{
    protected $fillable = [
        'name'
    ];

    public function connectionIssues(){
        return $this->hasMany('App\ConnectionIssue', 'id');
    }
}
