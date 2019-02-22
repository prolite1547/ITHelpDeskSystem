<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccumulatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accumulators', function (Blueprint $table) {
        
            // ACCUMULATORS
            $table->increments('id');
            $table->integer('sdc_id');
            $table->integer('trans_reset_count')->default(0);
            $table->integer('or_reset_count')->default(0);

            // ACCUM. NET SALES
            $table->text('vat_sales')->nullable();
            $table->text('non_vat_sales')->nullable();
            $table->text('z_rated_sales')->nullable();
            $table->text('vat_amount1')->nullable();
            $table->text('vat_exempt_amount1')->nullable();
            $table->text('total_net_sales')->nullable();
            
             // ACCUM. NET RETURNS
            $table->text('vat_ret')->nullable();
            $table->text('non_vat_ret')->nullable();
            $table->text('z_rated_ret')->nullable();
            $table->text('vat_amount2')->nullable();
            $table->text('vat_exempt_amount2')->nullable();
            $table->text('total_net_returns')->nullable();

            // ACCUM. NET SALES AFTER RETURNS
            $table->text('vat')->nullable();
            $table->text('non_vat')->nullable();
            $table->text('z_rated')->nullable();
            $table->text('vat_amount3')->nullable();
            $table->text('vat_exempt_3')->nullable();
            $table->text('total_after_returns')->nullable();

            $table->text('first_trx')->nullable();
            $table->text('last_trx')->nullable();
            $table->text('trx_count')->nullable();
            $table->text('prev_reading')->nullable();
            $table->text('curr_reading')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accumulators');
    }
}
