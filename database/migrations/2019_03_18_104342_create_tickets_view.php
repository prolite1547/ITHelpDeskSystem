<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE OR REPLACE VIEW v_tickets AS
    SELECT 
    t.id,
    p.name AS priority,
    ts.name AS status_name,
    t.status,
    t.expiration,
    t.created_at,
    t.assignee AS assignee_id,
    i.subject,
    i.details,
    c.name AS category,
    CONCAT(assignee.fName, \' \', assignee.lName) AS assignee,
    s.store_name,
    CONCAT(logger.fName, \' \', logger.lName) AS logged_by,
    tg.name AS ticket_group,
    IFNULL(extend_count,0) as extend_count
FROM
    tickets t
        JOIN
    incidents i ON t.id = i.id
        JOIN
    stores s ON t.store = s.id
        JOIN
    ticket_groups tg ON t.group = tg.id
        JOIN
    users assignee ON t.assignee = assignee.id
        JOIN
    users logger ON t.logged_by = logger.id
        JOIN
    ticket_status ts ON t.status = ts.id
        JOIN
    priorities p ON t.priority = p.id
		JOIN
	categories c ON i.category = c.id
    LEFT JOIN
	(SELECT e.ticket_id, COUNT(e.ticket_id) as extend_count FROM extends e
    GROUP BY e.ticket_id
    ORDER BY e.ticket_id) extend_counts ON t.id = extend_counts.ticket_id
WHERE
    t.deleted_at IS NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW v_tickets');
    }
}
