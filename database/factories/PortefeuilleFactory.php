<?php

use Faker\Generator as Faker;

$factory->define(App\Portefeuille::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 5),
        'crypto_id' => $faker->numberBetween(1, 10),
        'solde_euros' => $faker->numberBetween(1, 500)
    ];
});
