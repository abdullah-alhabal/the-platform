<?php

namespace App\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'is_public',
        'autoload',
    ];

    protected $casts = [
        'value' => 'json',
        'is_public' => 'boolean',
        'autoload' => 'boolean',
    ];

    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, $value, string $group = 'general'): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => gettype($value),
            ]
        );
    }

    public static function getPublic(): array
    {
        return static::where('is_public', true)
            ->where('autoload', true)
            ->pluck('value', 'key')
            ->toArray();
    }

    public static function getByGroup(string $group): array
    {
        return static::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }
} 