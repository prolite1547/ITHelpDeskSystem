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
            $table->unsignedInteger('resolved_by')->nullable();
            $table->unsignedInteger('type')->default(1);
            $table->unsignedInteger('priority');
            $table->unsignedInteger('status');
            $table->timestamp('expiration')->nullable();
            $table->timestamp('date_closed')->nullable();
            $table->foreign('incident_id')->references('id')->on('incidents')->onDelete('cascade');
            $table->foreign('assignee')->references('id')->on('users');
            $table->foreign('resolved_by')->references('id')->on('users');
            $table->foreign('status')->references('id')->on('categories');
            $table->foreign('type')->references('id')->on('categories');
            $table->foreign('priority')->references('id')->on('categories');
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
