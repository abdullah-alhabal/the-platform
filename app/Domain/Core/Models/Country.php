<?php

namespace App\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'phone_code',
        'currency_code',
        'currency_symbol',
        'flag',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function getFormattedPhoneCodeAttribute(): string
    {
        return '+' . ltrim($this->phone_code, '+');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getActive(): array
    {
        return static::where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'code')
            ->toArray();
    }

    public static function findByCode(string $code): ?self
    {
        return static::where('code', $code)->first();
    }
} 