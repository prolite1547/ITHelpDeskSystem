<?php

use Faker\Generator as Faker;

$factory->define(App\Call::class, function (Faker $faker) {



    return [
        'caller_id' => $faker->numberBetween(1,DB::table('callers')->count()),
        'user_id' => $faker->numberBetween(1,DB::table('users')->count()),
        'store_id' => $faker->numberBetween(1,DB::table('stores')->count()),
    ];
});


