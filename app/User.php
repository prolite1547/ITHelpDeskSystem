<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fName', 'mName', 'lName', 'email', 'password', 'uname', 'position_id', 'role_id','store_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function calls()
    {
        return $this->belongsToMany('App\Call', 'calls');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function ticketMessage()
    {
        return $this->hasMany('App\Message');
    }

    public function resolved()
    {
        return $this->hasMany('App\Resolve', 'resolved_by');
    }

    public function profpic()
    {
        return $this->hasOne('App\ProfPic');
    }

    public function ticketLogged()
    {
        return $this->hasMany('App\Call');
    }

    public function getFullNameAttribute()
    {
        $middle_name = $this->mName;

        return ucfirst($this->fName) . ' ' . $middle_name[0] .'.' . ' ' . ucfirst($this->lName);
    }

    public function assignedTickets()
    {
        return $this->hasMany('App\Ticket', 'assignee', 'id');
    }

    public function isDateBetween($start, $end, $created_at)
    {

        if (($created_at >= $start) && ($created_at <= $end)) {
            return true;
        } else {
            return false;
        }

    }

}
