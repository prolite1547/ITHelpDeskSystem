<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResolveCategory extends Model
{
    protected $table = 'resolve_categories';
    protected $fillable = [
        'name'
    ];

    public function resolve(){
        return $this->hasMany('App\Resolve','res_category','id');
    }
}
