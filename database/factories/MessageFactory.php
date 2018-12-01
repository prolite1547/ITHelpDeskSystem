<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'ticket_id' => $faker->numberBetween(1,DB::table('tickets')->count()),
        'user_id' => $faker->numberBetween(1,DB::table('users')->count()),
        'message' => $faker->text
    ];
});
