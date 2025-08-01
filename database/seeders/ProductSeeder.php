<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        
        for ($i = 1; $i <= 8; $i++) {
            Product::create([
                'name' => "Sample Product $i",
                'slug' => 'sample-product-' . $i,
                'regular_price' => rand(500, 2000),
                'stock' => rand(10, 100),
                'excerpt' => 'This is a short excerpt for product ' . $i,
                'description' => 'This is a long description for product ' . $i . '. You can write full HTML or markdown here.',
                'images' => json_encode([
                    'storage/app/public/products/3R2iW8Vi5SvQnf2iOZDmfr2LOd268cvHFx3oAfOb.png',
                    'storage/app/public/products/3R2iW8Vi5SvQnf2iOZDmfr2LOd268cvHFx3oAfOb.png',
                    'storage/app/public/products/3R2iW8Vi5SvQnf2iOZDmfr2LOd268cvHFx3oAfOb.png',
                ]),
                'category_id' => 1,
                'rating' => rand(1, 5),
                'review_count' => rand(0, 50),
                'status' => 1,
                'feature' => rand(0, 1),
            ]);
        }
    }
}
