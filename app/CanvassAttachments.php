<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanvassAttachments extends Model
{
    protected $fillable = [
        'path',
        'original_name',
        'mime_type',
        'extension',
        'canvass_form_id'
    ];
}
