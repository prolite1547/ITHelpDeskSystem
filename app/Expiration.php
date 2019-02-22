<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expiration extends Model
{
    protected $fillable = [
        'expiration'
    ];

    public function getCategoryB () {
        return $this->hasMany('App\CategoryB','expiration');
    }
}
