<?php

use Illuminate\Database\Seeder;

class CallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Call::class, 50)->create()->each(function ($t) {
            $t->incident()->save(factory(App\Incident::class)->make());
        });

    }
}
