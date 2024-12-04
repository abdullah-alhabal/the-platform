<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CountryTranslation.
 *
 * @property int $id
 * @property int $country_id
 * @property string $locale
 * @property string $name
 * @property string|null $currency_name
 * @property-read Country|null $country
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CountryTranslation query()
 *
 * @mixin \Eloquent
 */
final class CountryTranslation extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'country_id',
        'locale',
        'name',
        'currency_name',
    ];

    /**
     * Get the parent country of the translation.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
