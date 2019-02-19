<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionIssueRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection_issue_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('plain_text');
            $table->longText('html_body');
            $table->longText('reply');
            $table->boolean('hasAttachments');
            $table->string('subject');
            $table->string('from');
            $table->string('to');
            $table->string('cc');
            $table->string('reply_to');
            $table->timestamp('reply_date');
            $table->unsignedInteger('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('connection_issue_replies');
    }
}
