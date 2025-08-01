<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Cleaning',
            'Technology',
            'Lifestyle',
            'Consultant',
            'Business',
        ];

        foreach ($categories as $name) {
            BlogCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
        }
    }
}
