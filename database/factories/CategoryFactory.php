<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'status' => Category::STATUS_ACTIVE,
        'name' => $faker->bs,
    ];
});
