<?php

use Faker\Generator as Faker;

$factory->define(App\Call::class, function (Faker $faker) {

    $incCategory = DB::table('categories')->where('group',3)->orderByRaw('RAND()')->first(); /*Incident Category*/
    $priority = DB::table('categories')->where('group',2)->orderByRaw('RAND()')->first();
    $incCategoryA = DB::table('categories')->where('group',4)->orderByRaw('RAND()')->first();
    $incStatus = DB::table('categories')->where('group',5)->orderByRaw('RAND()')->first();

    return [
        'caller_id' => $faker->numberBetween(1,DB::table('callers')->count()),
        'user_id' => $faker->numberBetween(1,DB::table('users')->count()),
        'subject' => $faker->catchPhrase . ' ' .$faker->bs,
        'details' => $faker->text($faker->numberBetween(150,250)),
        'category' => $incCategory->id,
        'catA' => $incCategoryA->id,
        'priority' => $priority->id,
        'expiration' => now(),
        'atatus' => $incStatus->id,
    ];
});
