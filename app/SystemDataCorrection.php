<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemDataCorrection extends Model
{
     
    protected $fillable = [
        'ticket_no',
        'ticket_created',
        'sdc_no',
        'date_submitted',
        'requestor_name',
        'dept_supervisor',
        'department',
        'position',
        'affected_ss',
        'terminal_name',
        'hc_last_z_reading',
        'hc_last_dcr',
        'hc_last_transaction_id',
        'hc_last_accumulator',
        'hc_last_or_no',
        'sc_last_z_reading',
        'sc_last_transaction_id',
        'sc_last_accumulator',
        'sc_last_or_no',
        'findings_recommendations',
        'pre_acc_verified_by',
        'pre_acc_verified_date',
        'pre_next_z_reading',
        'pre_next_or_no',
        'pre_last_transaction_id',
        'pre_last_acc',
        'pre_last_or_no',
        'pre_verified_by',
        'pre_date_verified',
        'app_approved_by',
        'app_date_approved',
        'cp_request_assigned_to',
        'cp_date_completed',
        'cp_request_reviewed_by',
        'cp_date_reviewed',
        'cp_table_fields_affected',
        'dc_deployed_by',
        'dc_date_deployed',
        'dc_reviewed_by',
        'dc_date_reviewed',
        'post_verified_by',
        'post_date_verified',
        'status',
        'forward_status',
        'posted_by',
        'ty1_fullname',
        'ty1_date_verified',
        'ty1_remarks',
        'ty2_remarks',
        'accum_id',
        'govcomp_remarks',
        'h_group',
        'hierarchy',
        't1_datetime_apprvd',
        't2_datetime_apprvd',
        'govcomp_datetime_apprvd',
        'app_datetime_apprvd',
        'app_remarks'
    ];


    public function ticket(){
        return $this->belongsTo('App\Ticket','ticket_no');
    }

    public function attachments(){
        return $this->hasMany('App\SDCAttachment', 'sdc_no');
    }

    public function accumulators(){
        return $this->hasOne('App\Accumulators', 'sdc_id');
    }
   
}
