<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'discount',
        'total',
        'name',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'status',
        'delivered_date',
        'canceled_date',
        'payment_status',
        'payment_method',
    ];

    protected $dates = [
        'delivered_date',
        'canceled_date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
