<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create(
            [
                'name' => 'sample',
                'nickname' => 'sample',
                'email' => 'sample@sample.com',
                'password' => 'password',
            ]
        );

        App\User::create(
            [
                'name' => 'sample1',
                'email' => 'sample1@sample.com',
                'password' => 'password',
            ]
        );
    }
}
