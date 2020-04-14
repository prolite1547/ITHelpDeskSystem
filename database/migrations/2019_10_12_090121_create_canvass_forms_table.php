<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanvassFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvass_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedMediumInteger('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->string('remarks')->nullable();
            $table->string('purpose')->nullable();
            $table->boolean('posted')->default(0);
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
        Schema::dropIfExists('canvass_forms');
    }
}
