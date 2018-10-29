<?php

use Illuminate\Database\Seeder;

class CallersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Caller::class,30)->create();
    }
}
