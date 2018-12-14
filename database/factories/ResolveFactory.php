<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(App\Resolve::class, function (Faker $faker) {

    $res_category = DB::table('categories')->where('group',8)->orderByRaw('RAND()')->first();


    return [
        'cause' => $faker->text($faker->numberBetween(150,150)),
        'resolution' => $faker->text($faker->numberBetween(150,150)),
        'recommendation' => $faker->text($faker->numberBetween(150,150)),
        'res_category' => $res_category->id,
        'ticket_id' => 1,
        'resolved_by' => $faker->numberBetween(1,DB::table('users')->count()),
    ];
});



