<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fix extends Model
{
    protected $fillable = [
        'cause',
        'resolution',
        'recommendation',
        'fix_category',
        'fixed_by',
        'ticket_id',
    ];

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }

    public function resolveCategory(){
        return $this->belongsTo('App\ResolveCategory','fix_category');
    }

    public function fixedBy(){
        return $this->belongsTo('App\User','fixed_by')->withDefault(['name' => 'none']);
    }
}
