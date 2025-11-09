<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->bs;

    return [
        'status' => Category::STATUS_ACTIVE,
        'slug' => Str::slug($name),
        'name' => $name,
    ];
});
