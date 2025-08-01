<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'max_discount_amount',
        'min_cart_value',
        'start_date',
        'end_date',
        'usage_limit',
        'limit_per_user',
        'status',
        'first_time_users_only',
        'registered_users_only',
        'exclude_sale_items',
        'auto_apply',
        'eligible_categories',
    ];

    protected $casts = [
        'eligible_categories' => 'array',
        'start_date' => 'date',
        'expires_at' => 'datetime',
        'first_time_users_only' => 'boolean',
        'registered_users_only' => 'boolean',
        'exclude_sale_items' => 'boolean',
        'auto_apply' => 'boolean',
    ];
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'coupon_category', 'coupon_id', 'category_id');
    }
}

