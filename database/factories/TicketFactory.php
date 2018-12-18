<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {

    $priority = DB::table('categories')->where('group',2)->orderByRaw('RAND()')->first();
    $incStatus = DB::table('categories')->where('group',5)->orderByRaw('RAND()')->first();


    return [
        'incident_id' => function () {
            return factory(App\Incident::class)->create()->id;
        },
        'assignee' => $faker->numberBetween(1,DB::table('users')->count()),
        'type' => 1,
        'priority' => $priority->id,
        'status' => $incStatus->id,
        'expiration' => $faker->dateTimeBetween( 'now','+ 3 days'),
//        'created_at' => $faker->dateTime('- 1 days')
    ];
});

$factory->afterCreating(App\Ticket::class, function ($ticket, $faker) {

    if($ticket->status === 13){
        $ticket->resolve()->save(factory(App\Resolve::class)->make());
    }
});
