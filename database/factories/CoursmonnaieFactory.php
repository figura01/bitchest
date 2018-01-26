<?php

use Faker\Generator as Faker;



$factory->define(App\Coursmonnaie::class, function (Faker $faker) {

    return [
        'crypto_id' => $faker->numberBetween($min=1, $max=10),
        'date' => $faker->date('Y-m-d'),
        'taux' => 0

    ];
});

