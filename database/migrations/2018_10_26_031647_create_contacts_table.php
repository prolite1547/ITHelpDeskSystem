<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('number',40)->unique();
            $table->unsignedMediumInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedTinyInteger('type_id');
            $table->foreign('type_id')->references('id')->on('contact_types')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('telco_id')->nullable();
            $table->foreign('telco_id')->references('id')->on('telcos')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('tel_accounts')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('contacts');
    }
}
