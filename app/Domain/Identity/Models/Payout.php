<?php

namespace App\Domain\Identity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payout extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'marketer_id',
        'amount',
        'status',
        'payment_method',
        'transaction_id',
        'notes',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function marketer(): BelongsTo
    {
        return $this->belongsTo(Marketer::class);
    }

    public function isProcessed(): bool
    {
        return $this->processed_at !== null;
    }

    public function markAsProcessed(string $transactionId): void
    {
        $this->update([
            'status' => 'completed',
            'transaction_id' => $transactionId,
            'processed_at' => now(),
        ]);
    }

    public function markAsFailed(string $reason): void
    {
        $this->update([
            'status' => 'failed',
            'notes' => $reason,
        ]);
    }
} 