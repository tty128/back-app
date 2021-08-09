<?php

use Illuminate\Database\Seeder;

class TermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Laravel',
            'NuxtJS',
            'VueJS',
            'Java',
            'Javascript',
            'Typescript',
            'PHP'
        ];

        foreach ($tags as $tag) {
            App\Term::create(
                [
                    'taxonomy_id' => 2,
                    'name' => $tag,
                ]
            );
        }

        App\Term::create(
            [
                'taxonomy_id' => 1,
                'name' => 'uncategorized',
            ]
        );

        App\Term::create(
            [
                'taxonomy_id' => 1,
                'name' => 'Portfolio',
            ]
        );
    }
}
