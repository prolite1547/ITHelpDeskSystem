<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reject extends Model
{
    protected $table = 'rejected';
    protected $fillable = [
      'ticket_id',
      'reason',
      'rejected_by'
    ];

    public function scopeTae($query){
        return $query->latest()->first();
    }

    public function getUser(){
        return $this->belongsTo('App\User','rejected_by');
    }
}
