<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name'      => $name,
        'parent_id' => 0,
        'path'      => str_slug($name)
    ];
});
