<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'recipient',
        'phone',
        'line_one',
        'line_two',
        'city',
        'province',
        'postal_code',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'bool',
    ];

    /**
     * Address owner.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
