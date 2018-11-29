<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'path',
        'original_name',
        'incident_id',
        'extension',
        'mime_type'

    ];


    public function incident(){
        return $this->belongsTo('App\Incident');
    }
}
