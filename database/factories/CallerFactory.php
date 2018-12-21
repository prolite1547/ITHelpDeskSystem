<?php

use Faker\Generator as Faker;

$factory->define(App\Caller::class, function (Faker $faker) {
    return [
        'fName' => $faker->firstName,
        'mName' => $faker->lastName,
        'lName' => $faker->lastName,
        'store_id' => $faker->numberBetween(1,DB::table('stores')->count())
    ];
});
