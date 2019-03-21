<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResolvesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE OR REPLACE VIEW v_resolves AS
        SELECT 
            CONCAT_WS(\' \', u.fName, u.mName, u.lName) AS resolver,
            r.ticket_id,
            r.created_at AS resolved_date
        FROM
            resolves r
                JOIN
        users u ON r.resolved_by = u.id;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW v_resolves');
    }
}
