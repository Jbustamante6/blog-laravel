<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Taggable;
use Faker\Generator as Faker;

$factory->define(Taggable::class, function (Faker $faker) {
    return [
        'taggable_type' => $faker->title,
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'tag_id' => function () {
            return factory(App\Models\Tag::class)->create()->id || NULL;
        },
        'post_id' => function () {
            return factory(App\Models\Post::class)->create()->id || NULL;
        },
    ];
});
