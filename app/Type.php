<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'ticket_types';

    protected $fillable = [
      'name'
    ];
}