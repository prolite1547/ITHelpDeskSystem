<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectionIssue extends Model
{
    protected $fillable = [
        'account',
        'pid',
        'tel',
        'branch',
        'contact_person',
        'contact_number'
    ];


    public function incident(){
        return $this->hasOne('App\Incident');
    }
}
