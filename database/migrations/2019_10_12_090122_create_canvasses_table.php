<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanvassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvasses', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('ticket_id')->unsigned();
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->string('c_storename');
            $table->string('c_serial_no')->nullable();
            $table->string('c_itemdesc');
            $table->integer('c_qty');
            $table->integer('c_price');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items');
            $table->boolean('is_approved')->default(false);
            $table->integer('approval_id')->unsigned()->nullable();
            $table->foreign('approval_id')->references('id')->on('canvass_approvals');
            $table->string('app_code')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('date_installed')->nullable();
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
        Schema::dropIfExists('canvasses');
    }
}
