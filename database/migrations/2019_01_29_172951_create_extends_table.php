<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extends', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('ticket_id');
            $table->unsignedSmallInteger('extended_by');
            $table->text('details');
            $table->unsignedTinyInteger('duration');
            $table->timestamps();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('duration')->references('id')->on('expirations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('extended_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extends');
    }
}
