<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'images',
        'is_verified_purchase',
        'is_helpful',
        'helpful_count',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'is_helpful' => 'boolean',
        'rating' => 'integer',
        'helpful_count' => 'integer',
        'images' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
