<?php

namespace App\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'native_name',
        'rtl',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'rtl' => 'boolean',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }

    public static function getActive(): array
    {
        return static::where('is_active', true)
            ->pluck('name', 'code')
            ->toArray();
    }

    public function setAsDefault(): void
    {
        static::where('is_default', true)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        $this->update(['is_default' => true]);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
} 