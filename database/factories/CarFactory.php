<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Car::class, function (Faker $faker) {
    return [
        'year' => $faker->numberBetween(2000, 2020),
        'quantity' => $faker->numberBetween(0, 10),
        'make_id' => factory(\App\Models\Make::class)->create()->id,
        'model_id' => factory(\App\Models\Model::class)->create()->id
    ];
});

$factory->state(App\Models\Car::class, 'in-stock', function (\Faker\Generator $faker) {
    return [
        'quantity' => $faker->numberBetween(10, 20)
    ];
});

$factory->state(App\Models\Car::class, 'out-of-stock', [
    'quantity' => 0
]);
