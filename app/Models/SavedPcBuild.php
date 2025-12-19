<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedPcBuild extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pc_build_id',
        'custom_name',
        'progress_percent',
        'last_interacted_at',
    ];

    protected $casts = [
        'progress_percent' => 'int',
        'last_interacted_at' => 'datetime',
    ];

    /**
     * The owner of the saved build.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Linked master PC build preset.
     */
    public function pcBuild()
    {
        return $this->belongsTo(PcBuild::class);
    }
}
