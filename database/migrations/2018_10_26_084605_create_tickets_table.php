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
            $table->unsignedInteger('incident_id')->unique();
            $table->unsignedInteger('assignee')->nullable();
            $table->unsignedInteger('type')->default(1);
            $table->unsignedInteger('priority');
            $table->unsignedInteger('status');
            $table->dateTime('expiration');
            $table->foreign('incident_id')->references('id')->on('incidents')->onDelete('cascade');
            $table->foreign('assignee')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status')->references('id')->on('ticket_status')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('ticket_types')->onDelete('cascade');
            $table->foreign('priority')->references('id')->on('priorities')->onDelete('cascade');
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
        Schema::dropIfExists('tickets');
    }
}
