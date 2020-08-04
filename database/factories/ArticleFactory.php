<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    $user_ids = \App\User::pluck('id')->random();
    $category_ids = \App\Category::pluck('id')->random();
    $title = $faker->sentence(mt_rand(3, 10));
    return [
        'user_id' => $user_ids,
        'category_id' => $category_ids,
        'last_user_id' => $user_ids,
        'slug' => str_slug($title),
        'title' => $title,
        'subtitle' => strtolower($title),
        'content' => $faker->paragraph,
        'page_image' => 'https://picsum.photos/id/' . rand(1, 100) . '/640/480',
        'meta_description' => $faker->sentence,
        'is_draft' => false,
        'published_at' => $faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now')
    ];
});
