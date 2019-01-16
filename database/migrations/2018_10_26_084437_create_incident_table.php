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
            $table->string('subject')->nullable();
            $table->string('details')->nullable();
            $table->unsignedInteger('category')->nullable();
            $table->unsignedInteger('catA')->nullable();
            $table->unsignedInteger('catB')->nullable();
//            $table->unsignedInteger('catC')->nullable();
            $table->boolean('drd')->default(0);
            $table->foreign('call_id')->references('id')->on('calls')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('catA')->references('id')->on('category_a')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('catB')->references('id')->on('category_b')->onDelete('cascade')->onUpdate('cascade');
//            $table->foreign('catC')->references('id')->on('category_c')->onDelete('cascade');
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
