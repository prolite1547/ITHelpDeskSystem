<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ConnectionIssue extends Model
{
    protected $fillable = [
        'account',
        'pid',
        'tel',
        'branch',
        'contact_person',
        'contact_number',
        'to',
        'cc'
    ];


    public function incident(){
        return $this->morphOne('App\Incident','incident');
    }

    public function createTicketArray($userID,$catBID,$store){

        $expirationHours = CategoryB::findOrFail($catBID)->getExpiration->expiration;
        $expiration = Carbon::now()->addHours($expirationHours);

        return ['assignee' => $userID,'logged_by' => $userID,'type' => 1,'priority' => 4,'status' => 2,'store' => $store,'group' => 1,'expiration' => $expiration];
    }
}
