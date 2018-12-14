<?php

use Illuminate\Database\Seeder;

class ResolveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Resolve::class,100)->create();
    }
}
