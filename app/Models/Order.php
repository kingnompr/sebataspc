<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'progress_stage',
        'subtotal',
        'shipping_fee',
        'discount',
        'total',
        'courier',
        'estimated_delivery_at',
        'paid_at',
        'shipped_at',
        'metadata',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'estimated_delivery_at' => 'datetime',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Order owner.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Items included in the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope active (not delivered/cancelled) orders.
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['delivered', 'cancelled']);
    }
}
