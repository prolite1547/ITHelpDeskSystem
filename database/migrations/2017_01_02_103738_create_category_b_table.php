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
            $table->smallIncrements('id');
            $table->string('name',30)->unique();
            $table->unsignedTinyInteger('catA_id');
            $table->unsignedTinyInteger('expiration')->default(1);
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
