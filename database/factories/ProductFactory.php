<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'main_image' => 'macbook-pro.png',
        'details' => $faker->sentence,
        'quantity' => $faker->numberBetween(1, 20),
        'price' => $faker->randomFloat(2, 1000, 20000),
        'description' => $faker->paragraph,
        'featured' => $faker->randomElement([TRUE, FALSE]),
    ];
});
