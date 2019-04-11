<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resolve extends Model
{
    protected $fillable = [
        'fixes_id',
        'resolved_by'
    ];

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }
    public function fix(){
        return $this->belongsTo('App\Fix','fixes_id');
    }
}
