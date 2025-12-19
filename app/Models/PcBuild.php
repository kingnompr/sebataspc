<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcBuild extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'budget_min',
        'budget_max',
        'performance_tier',
        'use_case',
        'description',
    ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
    ];

    /**
     * Get the components for the PC build.
     */
    public function components()
    {
        return $this->hasMany(PcBuildComponent::class);
    }

    /**
     * Calculate the total price of the build.
     */
    public function getTotalPrice()
    {
        return $this->components->sum(function ($component) {
            return $component->product->price * $component->quantity;
        });
    }

    /**
     * Scope a query to filter by budget range.
     */
    public function scopeByBudget($query, $budget)
    {
        return $query->where('budget_min', '<=', $budget)
                     ->where('budget_max', '>=', $budget);
    }
}
