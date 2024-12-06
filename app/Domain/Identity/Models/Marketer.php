<?php

namespace App\Domain\Identity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marketer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'website',
        'commission_rate',
        'payment_details',
        'total_earnings',
        'current_balance',
        'last_payout_at',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'payment_details' => 'array',
        'last_payout_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class);
    }

    public function calculateCommission(float $amount): float
    {
        return round($amount * ($this->commission_rate / 100), 2);
    }

    public function addCommission(float $amount, string $description): void
    {
        $commission = $this->calculateCommission($amount);
        
        $this->commissions()->create([
            'amount' => $commission,
            'description' => $description,
        ]);

        $this->increment('total_earnings', $commission);
        $this->increment('current_balance', $commission);
    }

    public function processPayout(float $amount): bool
    {
        if ($amount > $this->current_balance) {
            return false;
        }

        $this->payouts()->create([
            'amount' => $amount,
            'status' => 'completed',
        ]);

        $this->decrement('current_balance', $amount);
        $this->update(['last_payout_at' => now()]);

        return true;
    }

    public function getMonthlyEarnings(): float
    {
        return $this->commissions()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');
    }

    public function getReferralCount(): int
    {
        return $this->referrals()->count();
    }

    public function getActiveReferralCount(): int
    {
        return $this->referrals()
            ->whereHas('user', function ($query) {
                $query->where('is_active', true);
            })
            ->count();
    }
} 