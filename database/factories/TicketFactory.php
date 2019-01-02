<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {

    $priority = DB::table('priorities')->orderByRaw('RAND()')->first();
    $incStatus = DB::table('ticket_status')->orderByRaw('RAND()')->first();


    return [
        'incident_id' => function () {
            return factory(App\Incident::class)->create()->id;
        },
        'status' => $incStatus->id,
        'assignee' => function() use ($faker,$incStatus){
            if($incStatus->id !== 1){
                return $faker->numberBetween(1,DB::table('users')->count());
            }else {
                return null;
            }
        },
        'type' => 1,
        'expiration' => $faker->dateTimeBetween( 'now','+ 3 days'),
//        'created_at' => $faker->dateTime('- 1 days')
        'priority' => $priority->id,
    ];
});

$factory->afterCreating(App\Ticket::class, function ($ticket, $faker) {

    if($ticket->status === 13){
        $ticket->resolve()->save(factory(App\Resolve::class)->make());
    }
});
