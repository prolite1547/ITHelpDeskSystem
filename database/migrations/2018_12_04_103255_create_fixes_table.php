<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixes', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('cause');
            $table->string('resolution');
            $table->string('recommendation');
            $table->unsignedTinyInteger('fix_category');
            $table->unsignedMediumInteger('ticket_id');
            $table->unsignedSmallInteger('fixed_by')->nullable();
            $table->foreign('fixed_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fix_category')->references('id')->on('resolve_categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('fixed');
    }
}
