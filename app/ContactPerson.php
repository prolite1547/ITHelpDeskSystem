<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    protected $fillable = [
      'contact_name',
      'store_id',
      'number_id'
    ];
}
