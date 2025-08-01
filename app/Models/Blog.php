<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'author',
        'images',
        'excerpt',
        'content',
        'published_at',
        'categories',
        'tags',
        'status'
    ];

    protected $casts = [
        'images'       => 'array',
        'categories'   => 'array',
        'tags'         => 'array',
        'published_at' => 'datetime',
        'status'       => 'boolean',
    ];


    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

}
