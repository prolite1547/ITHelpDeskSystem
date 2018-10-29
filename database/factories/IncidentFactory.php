<?php

use Faker\Generator as Faker;

$factory->define(App\Incident::class, function (Faker $faker) {
    return [
        'call_id' => function () {
            return factory(App\Call::class)->create()->id;
        }
    ];
});


