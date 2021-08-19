<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Tests\Models\{Post, User};
use Rockbuzz\LaraActivities\Models\Activity;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'type' => 'criado-post',
        'causer_id' => factory(User::class)->create()->id,
        'causer_type' => User::class,
        'subject_id' => factory(Post::class)->create()->id,
        'subject_type' => Post::class,
        'changes' => null
    ];
});
