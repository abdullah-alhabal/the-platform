<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CurrencyTranslation.
 *
 * @property int $id
 * @property int $currency_id
 * @property string $locale
 * @property string $name
 * @property-read Currency|null $currency
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CurrencyTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CurrencyTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CurrencyTranslation query()
 *
 * @mixin \Eloquent
 */
final class CurrencyTranslation extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'currency_id',
        'locale',
        'name',
    ];

    /**
     * Get the parent currency of the translation.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Accessor for the "locale" attribute.
     */
    public function getLocaleAttribute(): string
    {
        return mb_strtoupper($this->attributes['locale']);
    }

    /**
     * Mutator for the "locale" attribute.
     */
    public function setLocaleAttribute(string $value): void
    {
        $this->attributes['locale'] = mb_strtolower($value);
    }

    /**
     * Accessor for the "name" attribute.
     */
    public function getNameAttribute(): string
    {
        return ucfirst($this->attributes['name']);
    }

    /**
     * Mutator for the "name" attribute.
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = mb_strtolower($value);
    }
}
