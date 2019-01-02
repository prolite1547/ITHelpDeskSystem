<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryA extends Model
{
    protected $table = 'category_a';

    protected $fillable = [
        'name',
    ];

    public function subCategories(){
        return $this->hasMany('App\CategoryB','catA_id','id');
    }
}
