<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPcBuild extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'build_name',
        'budget',
        'use_case',
        'tier',
        'components',
        'total_price',
    ];

    protected $casts = [
        'components' => 'array',
        'budget' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the build.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all products in this build.
     */
    public function getProductsAttribute()
    {
        if (!$this->components) {
            return collect();
        }

        $productIds = array_values(array_filter($this->components));
        return Product::whereIn('id', $productIds)->get();
    }

    /**
     * Calculate total price from components.
     */
    public function calculateTotalPrice()
    {
        return $this->products->sum('price');
    }
}
