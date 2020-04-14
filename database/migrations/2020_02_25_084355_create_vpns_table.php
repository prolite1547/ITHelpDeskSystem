<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedMediumInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('vpn_num_id');
            $table->foreign('vpn_num_id')->references('id')->on('vpn_ids')->onUpdate('cascade')->onDelete('cascade');
            $table->string('vpn_num');
            $table->unsignedInteger('vpn_cat_id');
            $table->foreign('vpn_cat_id')->references('id')->on('vpn_categories')->onUpdate('cascade')->onDelete('cascade');            
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
        Schema::dropIfExists('vpns');
    }
}
