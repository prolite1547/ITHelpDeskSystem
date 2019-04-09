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
            $table->mediumIncrements('id');
            $table->text('plain_text');
            $table->text('html_body');
            $table->text('reply');
            $table->tinyInteger('hasAttachments');
            $table->string('subject');
            $table->text('from');
            $table->text('to');
            $table->text('cc');
            $table->string('reply_to');
            $table->timestamp('reply_date');
            $table->unsignedMediumInteger('ticket_id');
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
