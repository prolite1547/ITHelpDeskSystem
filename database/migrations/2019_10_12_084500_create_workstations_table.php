<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkstationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workstations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ws_description');
            $table->unsignedMediumInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->unsignedMediumInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->softDeletes();
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
        Schema::dropIfExists('workstations');
    }
}
