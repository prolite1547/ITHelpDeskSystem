<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryC extends Model
{
    protected $table = 'category_c';

    protected $fillable = [
        'name',
        'catB'
    ];

    public function catB(){
        return $this->belongsTo('App\CategoryB','catB');
    }
}
