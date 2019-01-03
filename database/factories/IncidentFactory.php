<?php

use App\CategoryB;
use Faker\Generator as Faker;

$factory->define(App\Incident::class, function (Faker $faker) {

    $incCategory = DB::table('categories')->orderByRaw('RAND()')->first(); /*Incident Category*/
    $incCategoryB = DB::table('category_b')->orderByRaw('RAND()')->first();


    return [
        'call_id' => function () {
            return factory(App\Call::class)->create()->id;
        },

        'subject' => $faker->catchPhrase . ' ' .$faker->bs,
        'details' => $faker->text($faker->numberBetween(150,150)),
        'category' => $incCategory->id,
        'catB' => $incCategoryB->id,
        'catA' => function() use ($incCategoryB){
                return CategoryB::findOrFail($incCategoryB->id)->group->id;
        }

    ];
});


