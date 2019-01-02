<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {

    $type = DB::table('contact_types')->orderByRaw('RAND()')->first();


    return [
        'number' =>  $faker->phoneNumber,
        'store_id' => $faker->numberBetween(1,DB::table('stores')->count()),
    ];
});
