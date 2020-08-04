<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $userId = \App\User::pluck('id')->random();
    $articleId = \App\Article::pluck('id')->random();
    return [
        'user_id' => $userId,
        'article_id' => $articleId,
        'content' => $faker->paragraph
    ];
});
