<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSDCAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_d_c_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type');
            $table->string('extension');
            $table->unsignedInteger('sdc_no');
            $table->foreign('sdc_no')->references('id')->on('system_data_corrections')->onDelete('cascade');
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
        Schema::dropIfExists('s_d_c_attachments');
    }
}
