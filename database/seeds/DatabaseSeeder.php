<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(TermTableSeeder::class);
        $this->call(TaxonomyTableSeeder::class);
        $this->call(PostTermTableSeeder::class);
    }
}
