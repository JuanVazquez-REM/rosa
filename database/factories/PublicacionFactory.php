<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Publicacion;
use Faker\Generator as Faker;

$factory->define(Publicacion::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->numberBetween(1,10),
        'title'=>$faker->sentence(2),
        'body'=>$faker->text(20),
        'imag'=>''

    ];
});
