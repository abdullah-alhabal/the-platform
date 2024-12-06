<?php

namespace App\Domain\Identity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'marketer_id',
        'user_id',
        'code',
        'status',
        'commission_rate',
        'expires_at',
        'converted_at',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'expires_at' => 'datetime',
        'converted_at' => 'datetime',
    ];

    public function marketer(): BelongsTo
    {
        return $this->belongsTo(Marketer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isConverted(): bool
    {
        return $this->converted_at !== null;
    }

    public function markAsConverted(): void
    {
        $this->update([
            'status' => 'converted',
            'converted_at' => now(),
        ]);
    }
} 