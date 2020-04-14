<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanvassForm extends Model
{   
    protected $table = 'canvass_forms';
    protected $fillable = [
        'ticket_id',
        'remarks',
        'purpose',
        'posted'
    ];

    public function canvass_attachments(){
        return $this->hasMany('App\CanvassAttachments', 'canvass_form_id', 'id');
    }
}
