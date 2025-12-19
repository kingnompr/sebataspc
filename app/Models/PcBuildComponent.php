<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcBuildComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'pc_build_id',
        'component_type',
        'product_id',
        'quantity',
    ];

    /**
     * Get the PC build that owns the component.
     */
    public function pcBuild()
    {
        return $this->belongsTo(PcBuild::class);
    }

    /**
     * Get the product for the component.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
