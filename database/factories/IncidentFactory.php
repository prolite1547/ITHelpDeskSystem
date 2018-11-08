<?php

use Faker\Generator as Faker;

$factory->define(App\Incident::class, function (Faker $faker) {

    $incCategory = DB::table('categories')->where('group',3)->orderByRaw('RAND()')->first(); /*Incident Category*/
    $incCategoryA = DB::table('categories')->where('group',4)->orderByRaw('RAND()')->first();


    return [
        'call_id' => function () {
            return factory(App\Call::class)->create()->id;
        },
        'subject' => $faker->catchPhrase . ' ' .$faker->bs,
        'details' => $faker->text($faker->numberBetween(150,250)),
        'category' => $incCategory->id,
        'catA' => $incCategoryA->id,

    ];
});


