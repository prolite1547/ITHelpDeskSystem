<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOracleUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oracle_users', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('fName',50);
            $table->string('mName', 50 )->nullable();
            $table->string('lName', 50 );
            $table->string('email', 50 );
            $table->string('uname', 50 );
            $table->unsignedMediumInteger('store_id');
            $table->unsignedSmallInteger('role_id');
            $table->unsignedMediumInteger('position_id');
            $table->unsignedMediumInteger('division_id');
            $table->unsignedMediumInteger('department_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oracle_users');
    }
}
