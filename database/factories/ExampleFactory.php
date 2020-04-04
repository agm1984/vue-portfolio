<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Example;
use Faker\Generator as Faker;

$factory->define(Example::class, function (Faker $faker, array $attributes) {
    return [
        'status' => Example::STATUS_ACTIVE,
        'category_id' => $attributes['category_id'] ?? factory(Category::class, 1)->create()->first()->id,
        'name' => $faker->catchPhrase,
        'image_url' => '/adam.png',
        'summary' => $faker->realText($faker->numberBetween(100, 2000), 1),
        'conclusion' => $faker->realText($faker->numberBetween(100, 2000), 1),
    ];
});
