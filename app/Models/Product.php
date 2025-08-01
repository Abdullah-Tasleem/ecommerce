<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'regular_price',
        'sale_price',
        'off',
        'excerpt',
        'description',
        'images',
        'stock',
        'categories',
        'tags',
        'rating',
        'review_count',
        'status',
        'feature'
    ];
    protected $casts = [
        'images' => 'array',
        'categories'   => 'array',
        'tags'         => 'array',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

}
