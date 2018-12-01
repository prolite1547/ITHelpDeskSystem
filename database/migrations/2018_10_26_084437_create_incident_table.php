<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('call_id')->unique();
            $table->string('subject');
            $table->string('details');
            $table->unsignedInteger('category');
            $table->unsignedInteger('catA');
            $table->unsignedInteger('catB')->nullable();
            $table->unsignedInteger('catC')->nullable();
            $table->boolean('drd')->default(0);
            $table->foreign('call_id')->references('id')->on('calls')->onDelete('cascade');
            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('catA')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('catB')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('catC')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('incidents');
    }
}
