<?php

use Illuminate\Database\Seeder;

class PostTermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\PostTerm::create(
            [
                'post_id' => 1,
                'term_id' => 1,
            ]
        );
        App\PostTerm::create(
            [
                'post_id' => 1,
                'term_id' => 2,
            ]
        );
    }
}
