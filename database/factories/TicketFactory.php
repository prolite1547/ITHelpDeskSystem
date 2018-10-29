<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {
    return [
        'incident_id' => function () {
            return factory(App\Incident::class)->create()->id;
        },
        'assignee' => $faker->numberBetween(1,DB::table('users')->count()),
        'resolved_by' => $faker->numberBetween(1,DB::table('users')->count()),
        'date_closed'=> now(),
        'type' => 1
    ];
});
