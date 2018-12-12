<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManualDataCorrectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_data_corrections', function (Blueprint $table) {

            $table->increments('id');
            $table->text('ticket_no');
            $table->text('mdc_no');
            $table->string('date_submitted');
            $table->string('requestor_name');
            $table->string('position');
            $table->string('department');

            $table->text('affected_ss')->nullable();
            $table->text('affected_date')->nullable();
            $table->text('findings_recommendations')->nullable();

            // PRE-CORRECTION VERIFICATION
            $table->string('verified_by')->nullable();
            $table->boolean('verified_by_signed')->default(0);
            $table->text('pre_should_be_data')->nullable();
            $table->string('pre_verified_by')->nullable();
            $table->boolean('pre_verified_signed')->default(0);
            $table->string('pre_date_verified')->nullable();

            // APPROVAL OF THE CORRECTION REQUEST
            $table->string('app_head_approver')->nullable();
            $table->boolean('app_head_approver_signed')->default(0);
            $table->string('app_head_approver_date')->nullable();
            $table->string('app_approver')->nullable();
            $table->boolean('app_approver_signed')->default(0);
            $table->string('app_approver_date')->nullable();

            // CORRECTION PROCESSING 
            $table->string('cp_request_assignedTo')->nullable();
            $table->string('cp_date_completed')->nullable();
            $table->string('cp_request_reviewedBy')->nullable();
            $table->string('cp_date_reviewed')->nullable();

            // DEPLOYMENT CONFIRMATION
            $table->string('dc_deployed_by')->nullable();
            $table->boolean('dc_deployed_signed')->default(0);
            $table->string('dc_date_deployed')->nullable();
            $table->string('dc_reviewed_by')->nullable();
            $table->boolean('dc_reviewed_signed')->default(0);
            $table->string('dc_date_reviewed')->nullable();
            
            // POST CORRECTION VERIFICATION 
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
        Schema::dropIfExists('manual_data_corrections');
    }
}
