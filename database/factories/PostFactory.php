<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->paragraph,
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});
