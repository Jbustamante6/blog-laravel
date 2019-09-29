<?php

use Illuminate\Database\Seeder;


class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'User Test',
            'email' => 'mail@mail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
