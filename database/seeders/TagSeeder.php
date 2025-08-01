<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Type / Style
            'Sofa',
            'Chair',
            'Recliner',
            'Sofa Bed',
            'Lounge Chair',
            'Ottoman',
            'Armchair',
            'Dining Chair',
            'Office Chair',

            // Material
            'Leather',
            'Fabric',
            'Velvet',
            'Suede',
            'Wood',
            'Metal',

            // Size / Capacity
            'Single Seater',
            '2 Seater',
            '3 Seater',
            'L-Shaped',
            'Modular',
            'Compact',
            'Oversized',

            // Colors
            'Black',
            'White',
            'Grey',
            'Beige',
            'Brown',
            'Navy Blue',
            'Green',
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'status' => 1
            ]);
        }
    }
}
