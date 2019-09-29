<?php

use Illuminate\Database\Seeder;

class TagSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            ["name" => str_random(20),],
            ["name" => str_random(20),],
            ["name" => str_random(20),],
            ["name" => str_random(20),],
            ["name" => str_random(20),],
            ["name" => str_random(20),],
            ["name" => str_random(20),],
        ]);
    }
}
