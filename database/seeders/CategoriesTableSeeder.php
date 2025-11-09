<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['status' => Category::STATUS_ACTIVE, 'name' => 'Projects'],
            ['status' => Category::STATUS_ACTIVE, 'name' => 'Courses'],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(
                ['name' => $data['name']], // uniqueness condition
                [
                    'status' => $data['status'],
                    'slug'   => Str::slug($data['name']),
                ]
            );
        }
    }
}