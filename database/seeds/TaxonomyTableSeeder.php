<?php

use Illuminate\Database\Seeder;

class TaxonomyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Taxonomy::create(
            [
                'name' => 'category',
            ]
        );
        App\Taxonomy::create(
            [
                'name' => 'tag',
            ]
        );

    }
}
