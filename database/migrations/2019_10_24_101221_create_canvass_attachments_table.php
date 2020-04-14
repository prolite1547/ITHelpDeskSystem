<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanvassAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvass_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type');
            $table->string('extension');
            $table->unsignedInteger('canvass_form_id');
            $table->foreign('canvass_form_id')->references('id')->on('canvass_forms')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('canvass_attachments');
    }
}
