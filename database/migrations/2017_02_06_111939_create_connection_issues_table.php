<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection_issues', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('to');
            $table->string('cc')->nullable();
            $table->string('accounts')->nullable();
            $table->text('vpn_details')->nullable();
            $table->string('tel')->nullable();
            $table->unsignedInteger('telco_id')->nullable();
            $table->foreign('telco_id')->references('id')->on('telcos')->onUpdate('cascade')->onDelete('cascade');
            $table->string('contact_person');
            $table->string('contact_number');
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
        Schema::dropIfExists('connection_issues');
    }
}
