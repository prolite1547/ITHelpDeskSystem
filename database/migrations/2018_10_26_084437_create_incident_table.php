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
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('call_id')->nullable();
            $table->unsignedMediumInteger('connection_id')->nullable();
            $table->text('subject')->nullable();
            $table->text('details')->nullable();
            $table->unsignedTinyInteger('category')->nullable();
            $table->unsignedTinyInteger('catA')->nullable();
            $table->unsignedSmallInteger('catB')->nullable();
            $table->unsignedSmallInteger('catC')->nullable();
            $table->boolean('drd')->default(0);
            $table->foreign('call_id')->references('id')->on('calls')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('catA')->references('id')->on('category_a')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('catB')->references('id')->on('category_b')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('catC')->references('id')->on('category_c')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('connection_id')->references('id')->on('connection_issues')->onDelete('cascade')->onUpdate('cascade');
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
