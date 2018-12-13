<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {

    $priority = DB::table('categories')->where('group',2)->orderByRaw('RAND()')->first();
    $incStatus = DB::table('categories')->where('group',5)->where('id','!=',13)->orderByRaw('RAND()')->first();


    return [
        'incident_id' => function () {
            return factory(App\Incident::class)->create()->id;
        },
        'assignee' => $faker->numberBetween(1,DB::table('users')->count()),
        'type' => 1,
        'priority' => $priority->id,
        'status' => $incStatus->id,
        'expiration' => $faker->dateTimeBetween( 'now','+ 3 days'),
        'created_at' => $faker->dateTime('- 1 days')
    ];
});
