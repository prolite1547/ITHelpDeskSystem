<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workstation_id')->unsigned();
            $table->foreign('workstation_id')->references('id')->on('workstations');
            $table->string('serial_no')->nullable();
            $table->string('item_description');
            $table->integer('itemcateg_id')->unsigned();
            $table->foreign('itemcateg_id')->references('id')->on('item_categs');
            $table->integer('no_repaired')->default(0);
            $table->integer('no_replace')->default(0);
            $table->date('date_used')->nullable();
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
        Schema::dropIfExists('items');
    }
}
