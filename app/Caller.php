<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caller extends Model
{
    protected $fillable = [
        'name',
        'store_id',
    ];
}
