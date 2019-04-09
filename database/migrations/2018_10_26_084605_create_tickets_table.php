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
            $table->mediumIncrements('id');
            $table->morphs('issue');
            $table->unsignedSmallInteger('assignee')->nullable();
            $table->unsignedSmallInteger('logged_by')->nullable();
            $table->unsignedTinyInteger('type')->default(1);
            $table->unsignedTinyInteger('priority')->nullable();
            $table->unsignedTinyInteger('status');
            $table->morphs('store');
            $table->unsignedTinyInteger('group')->nullable();;
            $table->dateTime('expiration')->nullable();;
            $table->foreign('assignee')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('logged_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status')->references('id')->on('ticket_status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type')->references('id')->on('ticket_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('priority')->references('id')->on('priorities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('group')->references('id')->on('ticket_groups')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('prt_id')->nullable();
            $table->text('crt_id')->nullable();
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
