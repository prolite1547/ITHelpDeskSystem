<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SDCAttachment extends Model
{
    protected $table = 's_d_c_attachments';
    protected $fillable = [
        'path',
        'original_name',
        'sdc_no',
        'extension',
        'mime_type'
    ];

    public function sdc(){
        $this->belongsTo('App\SystemDataCorrection', 'sdc_no');
    }
 
}
