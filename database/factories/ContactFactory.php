<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {

    $type = DB::table('categories')->where('group',6)->orderByRaw('RAND()')->first();


    return [
        'number' =>  $faker->phoneNumber,
        'store_id' => $faker->numberBetween(1,DB::table('stores')->count()),
        'type' => $type->id
    ];
});
