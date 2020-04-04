<?php

use App\Category;
use App\Example;
use Illuminate\Database\Seeder;

class ExamplesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects_id = Category::query()->firstWhere('name', 'Projects');
        $courses_id = Category::query()->firstWhere('name', 'Courses');

        $examples = [
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'content marketing platform',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'business management portal',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'Mackintosh Windows',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $projects_id,
                'name' => 'clock angle calculator',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'react 16 complete guide',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'modern react with redux',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'advanced react and redux',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'graphql with react',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'advanced node.js',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'react native and redux',
            ],
            [
                'status' => Example::STATUS_ACTIVE,
                'category_id' => $courses_id,
                'name' => 'web developer bootcamp',
            ]
        ];

        foreach ($examples as $example) {
            $exists = Example::query()->where('name', $example['name'])->first();

            if (!$exists) {
                factory(Example::class, 1)->create($example);
            }
        }
    }
}
