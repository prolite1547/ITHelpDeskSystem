<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryB extends Model
{
    protected $table = 'category_b';

    protected $fillable = [
        'name',
        'catA_id',
        'expiration'
    ];

    public function group() {
        return $this->belongsTo('App\CategoryA','catA_id','id');
    }

    public function getExpiration(){
        return $this->belongsTo('App\Expiration','expiration');
    }

    public function subCategories(){
        return $this->hasMany('App\CategoryC','catB');
    }
}
