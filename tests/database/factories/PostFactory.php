<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Tests\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->text
    ];
});
