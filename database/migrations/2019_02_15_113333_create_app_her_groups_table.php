<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppHerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_her_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string("group");
            $table->integer("approver1");
            $table->integer("approver2")->nullable();
            $table->integer("approver3")->nullable();
            $table->integer("approver4")->nullable();
            $table->text("s_hierarchy")->nullable();
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
        Schema::dropIfExists('app_her_groups');
    }
}
