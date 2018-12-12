<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualDataCorrection extends Model
{
    protected $fillable = [
        'ticket_no',
        'mdc_no',
        'date_submitted',
        'requestor_name',
        'position',
        'department',
        'affected_ss',
        'affected_date',
        'findings_recommendations',
        'verified_by',
        'pre_should_be_data',
        'pre_verified_by',
        'pre_date_verified',
        'app_head_approver',
        'app_head_approver_date',
        'app_approver',
        'app_approver_date',
        'cp_request_assignedTo',
        'cp_date_completed',
        'cp_request_reviewedBy',
        'cp_date_reviewed',
        'dc_deployed_by',
        'dc_date_deployed',
        'dc_reviewed_by',
        'dc_date_reviewed',
        'post_verified_by',
        'post_date_verified'
    ];

    
    public function ticket(){
        return $this->belongsTo('App\Ticket','ticket_no');
    }
}
