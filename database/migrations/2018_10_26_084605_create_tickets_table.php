<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('incident_id');
            $table->unsignedInteger('assignee');
            $table->unsignedInteger('resolved_by');
            $table->integer('type');
            $table->foreign('assignee')->references('id')->on('users');
            $table->foreign('resolved_by')->references('id')->on('users');
            $table->foreign('incident_id')->references('id')->on('incidents');
            $table->timestamp('date_closed');
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
        Schema::dropIfExists('tickets');
    }
}
