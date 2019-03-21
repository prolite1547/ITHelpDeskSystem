<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void(.*), (.*)
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('fName',50);
            $table->string('mName', 50 )->nullable();
            $table->string('lName', 50 );
            $table->string('uname', 50 )->nullable();
            $table->string('email', 50 )->nullable();
            $table->unsignedMediumInteger('store_id')->nullable();
            $table->unsignedSmallInteger('role_id')->default(3);
            $table->unsignedMediumInteger('position_id');
            $table->unsignedMediumInteger('division_id')->nullable();
            $table->unsignedMediumInteger('department_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->morphs('userable');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('users');
    }
}
