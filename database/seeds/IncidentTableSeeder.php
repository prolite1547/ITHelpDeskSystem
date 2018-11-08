<?php

use Illuminate\Database\Seeder;

class IncidentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Incident::class, 50)->create()->each(function ($i) {
            $i->ticket()->save(factory(App\Ticket::class)->make());
        });
    }
}
