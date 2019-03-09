<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedSmallInteger('caller_id');
            $table->unsignedSmallInteger('user_id');
//            $table->unsignedInteger('contact_id');
            $table->foreign('caller_id')->references( 'id')->on('callers')->onDelete('cascade');
//            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('calls');
    }
}
