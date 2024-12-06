<?php

namespace App\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country_id',
        'name',
        'state',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name}, {$this->state}, {$this->country->name}";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getByCountry(int $countryId): array
    {
        return static::where('country_id', $countryId)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getCoordinates(): array
    {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude,
        ];
    }
} 