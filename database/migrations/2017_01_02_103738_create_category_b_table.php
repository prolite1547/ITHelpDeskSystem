<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_b', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->unsignedInteger('catA_id');
            $table->unsignedInteger('expiration')->default(1);
            $table->timestamps();
            $table->foreign('catA_id')->references('id')->on('category_a')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('expiration')->references('id')->on('expirations')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_b');
    }
}
