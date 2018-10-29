<?php

use Faker\Generator as Faker;

$factory->define(App\Caller::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'store_id' => $faker->numberBetween(1,DB::table('stores')->count())
    ];
});
