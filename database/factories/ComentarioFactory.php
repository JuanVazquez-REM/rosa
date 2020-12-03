<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comentario;
use Faker\Generator as Faker;

$factory->define(Comentario::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->numberBetween(1,10),
        'post_id'=>$faker->numberBetween(1,30),
        'body'=>$faker->text(5)

    ];
});
