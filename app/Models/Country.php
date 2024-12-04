<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country.
 *
 * @property int $id
 * @property string $code
 * @property string|null $flag_url
 * @property int $currency_id
 *
 * @method static Builder|Country withLocale(string $locale = 'en')
 *
 * @property-read Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CountryTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static Builder<static>|Country newModelQuery()
 * @method static Builder<static>|Country newQuery()
 * @method static Builder<static>|Country query()
 *
 * @mixin \Eloquent
 */
final class Country extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'code',
        'flag_url',
        'currency_id',
    ];

    /**
     * Get the translations for the country.
     */
    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CountryTranslation::class);
    }

    /**
     * Relationship with the Currency model.
     */
    public function currency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Scope to fetch a country by locale.
     */
    public function scopeWithLocale(Builder $query, string $locale = 'en'): Builder
    {
        return $query->with(['translations' => function ($query) use ($locale): void {
            $query->where('locale', $locale);
        }]);
    }

    // Getter for $code
    public function getCode(): string
    {
        return $this->code;
    }

    // Setter for $code
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    // Getter for $flag_url
    public function getFlagUrl(): ?string
    {
        return $this->flag_url;
    }

    // Setter for $flag_url
    public function setFlagUrl(?string $flag_url): void
    {
        $this->flag_url = $flag_url;
    }

    // Getter for $currency_id
    public function getCurrencyId(): int
    {
        return $this->currency_id;
    }

    // Setter for $currency_id
    public function setCurrencyId(int $currency_id): void
    {
        $this->currency_id = $currency_id;
    }

    public function getLocalizedCurrencyName(string $locale = 'en'): ?string
    {
        return $this->currency->translations()
            ->where('locale', $locale)
            ->value('name');
    }
}
