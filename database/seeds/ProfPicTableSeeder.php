<?php

use Illuminate\Database\Seeder;

class ProfPicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ProfPic::class,30)->create();
    }
}
