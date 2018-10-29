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
            $table->increments('id');
            $table->unsignedInteger('caller_id');
            $table->unsignedInteger('user_id');
            $table->foreign('caller_id')->references('id')->on('callers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('subject');
            $table->string('details');
            $table->string('category');
            $table->string('catA');
            $table->string('catB')->default(0);
            $table->string('catC')->default(0);
            $table->string('priority');
            $table->timestamp('expiration');
            $table->string('atatus');
            $table->string('files')->default('');
            $table->boolean('drd')->default(0);
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
