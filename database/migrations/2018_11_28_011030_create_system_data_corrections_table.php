<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemDataCorrectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_data_corrections', function (Blueprint $table) {

            $table->increments('id');
            $table->text('ticket_no');
            $table->text('sdc_no');
            $table->string('date_submitted');
            $table->string('requestor_name');
            $table->string('dept_supervisor');
            $table->string('department');
            $table->string('position');

            //DETAILS
            $table->string('affected_ss')->nullable();
            $table->string('terminal_name')->nullable();


            //HARD COPY FOR POS
            $table->text('hc_last_z_reading')->nullable();
            $table->text('hc_last_dcr')->nullable();
            $table->text('hc_last_transaction_id')->nullable();
            $table->boolean('hc_last_accumulator')->nullable();
            $table->text('hc_last_or_no')->nullable();
            
             //SOFT COPY FOR POS
             $table->text('sc_last_z_reading')->nullable();
             $table->text('sc_last_transaction_id')->nullable();
             $table->boolean('sc_last_accumulator')->nullable();
             $table->text('sc_last_or_no')->nullable();

             $table->text('findings_recommendations')->nullable();
             //-- DETAILS


            //PRE-CORRECTION VERIFICATION
            $table->string('pre_acc_verified_by')->nullable();
            $table->boolean('pre_acc_verified_signed')->default(0);
            $table->string('pre_acc_verified_date')->nullable();
            $table->text('pre_next_z_reading')->nullable();
            $table->text('pre_next_or_no')->nullable();
            $table->text('pre_last_transaction_id')->nullable();
            $table->text('pre_last_acc')->nullable();
            $table->text('pre_last_or_no')->nullable();
            $table->string('pre_verified_by')->nullable();
            
            $table->boolean('pre_verified_signed')->default(0);

            $table->string('pre_date_verified')->nullable();

            
            //APPROVAL OF THE CHANGE REQUEST
            $table->string('app_approved_by')->nullable();
            $table->boolean('app_approved_signed')->default(0);
            $table->string('app_date_approved')->nullable();

            //CHANGE PROCESSING
            $table->string('cp_request_assigned_to')->nullable();
           
            $table->string('cp_date_completed')->nullable();
            $table->string('cp_request_reviewed_by')->nullable();
           
            $table->string('cp_date_reviewed')->nullable();
            $table->text('cp_table_fields_affected')->nullable();

            //DEPLOYMENT CONFIRMATION

            $table->string('dc_deployed_by')->nullable();
            $table->boolean('dc_deployed_signed')->default(0);
            $table->string('dc_date_deployed')->nullable();
            $table->string('dc_reviewed_by')->nullable();
            $table->boolean('dc_reviewed_signed')->default(0);
            $table->string('dc_date_reviewed')->nullable();

            //POST-CORRECTION VERIFICATION
            $table->string('post_verified_by')->nullable();
            $table->boolean('post_verified_signed')->default(0);
            $table->string('post_date_verified')->nullable();

            $table->boolean('posted')->default(0);
            

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
        Schema::dropIfExists('system_data_corrections');
    }
}
