<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;


class FactorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'User Test',
            'email' => 'mail@mail.com',
            'password' => Hash::make('123456')
        ]);
        factory(Post::class)->create();
        factory(Tag::class)->create();
        factory(Taggable::class)->create();

    }
}
