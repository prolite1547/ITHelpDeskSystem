<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryCsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_c', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name',50);
            $table->unsignedSmallInteger('catB');
            $table->timestamps();
            $table->foreign('catB')->references('id')->on('category_b')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_cs');
    }
}
