<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accumulators extends Model
{
     protected $fillable = [
        'sdc_id',
        'trans_reset_count',
        'or_reset_count',
        'vat_sales',
        'non_vat_sales',
        'z_rated_sales',
        'vat_amount1',
        'vat_exempt_amount1',
        'total_net_sales',
        'vat_ret',
        'non_vat_ret',
        'z_rated_ret',
        'vat_amount2',
        'vat_exempt_amount2',
        'total_net_returns',
        'vat',
        'non_vat',
        'z_rated',
        'vat_amount3',
        'vat_exempt_3',
        'total_after_returns',
        'first_trx',
        'last_trx',
        'trx_count',
        'prev_reading',
        'curr_reading'
     ];


     public function sdc(){
      return $this->belongsTo('App\Accumulators', 'accum_id');
  }
}
