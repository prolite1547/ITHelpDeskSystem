<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResolvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolves', function (Blueprint $table) {
            $table->unsignedMediumInteger('fixes_id');
            $table->unsignedSmallInteger('resolved_by');
            $table->foreign('fixes_id')->references('id')->on('fixes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('resolved_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['fixes_id','resolved_by']);
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
        Schema::dropIfExists('resolves');
    }
}
