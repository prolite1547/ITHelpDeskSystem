<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'ticket_status';

    protected $fillable = [
        'name'
    ];


    public function openIncidents(){
        return $this->hasMany('App\Incident','status','id');
    }
}
