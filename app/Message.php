<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
class Message extends Model
{

    protected $fillable = [
        'user_id',
        'ticket_id',
        'message'];

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }
}
