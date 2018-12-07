<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfPic extends Model
{
    protected $table = 'profpics';
    protected $fillable = [
        'user_id',
        'image'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
