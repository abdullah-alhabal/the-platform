<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Currency.
 *
 * @property int $id
 * @property string $code
 * @property float $exchange_rate
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Country> $countries
 * @property-read int|null $countries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CurrencyTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency query()
 *
 * @mixin \Eloquent
 */
final class Currency extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'code',
        'exchange_rate',
    ];

    /**
     * Relationship with countries.
     */
    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }

    /**
     * Relationship with currency translations.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(CurrencyTranslation::class);
    }

    /**
     * Accessor for the "code" attribute.
     */
    public function getCodeAttribute(): string
    {
        return mb_strtoupper($this->attributes['code']);
    }

    /**
     * Mutator for the "code" attribute.
     */
    public function setCodeAttribute(string $value): void
    {
        $this->attributes['code'] = mb_strtolower($value);
    }

    /**
     * Accessor for the "exchange_rate" attribute.
     */
    public function getExchangeRateAttribute(): float
    {
        return (float) $this->attributes['exchange_rate'];
    }

    /**
     * Mutator for the "exchange_rate" attribute.
     */
    public function setExchangeRateAttribute(float $value): void
    {
        $this->attributes['exchange_rate'] = round($value, 2);
    }
}
