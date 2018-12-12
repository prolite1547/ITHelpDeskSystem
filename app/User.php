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
        'name', 'email', 'password','uname','user_id','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function calls(){
        return $this->belongsToMany('App\Call','calls');
    }

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function ticketMessage(){
        return $this->hasMany('App\Message');
    }

    public function resolved(){
        return $this->hasMany('App\Resolve','resolved_by');
    }

    public function profpic(){
        return $this->hasOne('App\ProfPic');
    }

     public function ticketLogged(){
         return $this->hasMany('App\Call');
     }


     public function isDateBetween($start,$end, $created_at){

        if (( $created_at >= $start) && ($created_at <= $end)){
            return true;
        }else{
            return false;
        }
    
     }
    
}
