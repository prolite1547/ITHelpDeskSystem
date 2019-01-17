<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AfterUsersInsertTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER after_users_insert
            AFTER INSERT ON users
            FOR EACH ROW 
            BEGIN
                INSERT INTO profpics
                SET 
                    user_id = NEW.id,
                    image = "default.png",
                    created_at = NOW(),
                    updated_at = NOW(); 
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER "after_users_insert"');
    }
}
