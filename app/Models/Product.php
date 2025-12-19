<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'specifications',
        'price',
        'stock',
        'image',
        'is_featured',
        'is_recommended',
        'rating',
        
        // General Product Info
        'brand',
        'model',
        'sku',
        
        // CPU/Motherboard Compatibility
        'socket',
        'chipset',
        
        // RAM Compatibility
        'memory_type',
        'memory_speed',
        'memory_slots',
        
        // Storage Compatibility
        'interface',
        'capacity_gb',
        
        // Power & Thermal
        'tdp',
        'wattage',
        'efficiency_rating',
        
        // Physical Dimensions
        'form_factor',
        'length_mm',
        'height_mm',
        
        // Compatibility Arrays
        'compatible_sockets',
        'supported_memory_types',
        'rgb_support',
        
        // Stock Management
        'min_stock_alert',
        'last_restock_date',
        
        // Pricing Management
        'cost_price',
        'markup_percentage',
    ];

    protected $casts = [
        'specifications' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_recommended' => 'boolean',
        'compatible_sockets' => 'array',
        'supported_memory_types' => 'array',
        'rgb_support' => 'boolean',
        'cost_price' => 'decimal:2',
        'markup_percentage' => 'decimal:2',
        'last_restock_date' => 'date',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include recommended products.
     */
    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    /**
     * Scope a query to only include in-stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Get the product image URL.
     * Returns actual image from database if exists, otherwise returns null.
     */
    public function getImageUrlAttribute()
    {
        // Return actual image path from database if exists
        if ($this->image) {
            // Check if it's already a full URL
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            // Check if file exists in public folder
            if (file_exists(public_path($this->image))) {
                return asset($this->image);
            }
            // Return as-is (might be external URL or will be handled by frontend)
            return $this->image;
        }
        
        // No image available
        return null;
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
