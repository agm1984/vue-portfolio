<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'status' => Category::STATUS_ACTIVE,
                'name' => 'Projects',
            ],
            [
                'status' => Category::STATUS_ACTIVE,
                'name' => 'Courses',
            ]
        ];

        foreach ($categories as $category) {
            $exists = Category::query()->where('name', $category['name'])->first();

            if (!$exists) {
                factory(Category::class, 1)->create(array_merge($category, [
                    'slug' => Str::slug($category['name']),
                ]));
            }
        }

    }
}
