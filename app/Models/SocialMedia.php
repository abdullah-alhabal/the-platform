<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read string $name
 * @property-write mixed $key
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SocialMediaTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialMedia query()
 *
 * @mixin \Eloquent
 */
final class SocialMedia extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'key',
        'icon',
        'class',
    ];

    public function translations()
    {
        return $this->hasMany(SocialMediaTranslation::class);
    }

    public function getNameAttribute(): string
    {
        return $this->translations()->where('locale', app()->getLocale())->value('name') ?? '';
    }

    public function setKeyAttribute($value): void
    {
        $this->attributes['key'] = mb_strtolower($value);
    }
}
