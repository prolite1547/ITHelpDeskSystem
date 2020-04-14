<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCateg extends Model
{
    protected $table = "item_categs";
    protected $fillable = [
        'name'
    ];
}
