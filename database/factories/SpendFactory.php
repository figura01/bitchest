<?php

use Faker\Generator as Faker;

$factory->define(App\Spend::class, function (Faker $faker) {
    return [
        'date_achat' => $faker->date('Y-m-d'),
        'quantité' => $faker->numberBetween($min=1, $max= 10),
        'valeur_euros' => $faker->numberBetween($min=1, $max=500),
        'active'  => $faker->boolean($chanceOfGettingTrue = 50),
        'coursmonnaie_id'=>1,
        'crypto_id' => $faker->numberBetween($min=1, $max=10),
        'user_id' => $faker->numberBetween($min=1, $max=5)

    ];
});
