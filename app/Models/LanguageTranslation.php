<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class LanguageTranslation.
 *
 * @property int $id
 * @property int $language_id
 * @property string $locale
 * @property string $title
 * @property-read Language $language
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguageTranslation query()
 *
 * @mixin \Eloquent
 */
final class LanguageTranslation extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'language_id',
        'locale',
        'title',
    ];

    /**
     * Get the language that owns the translation.
     *
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    // Accessors and Mutators

    /**
     * Get the language_id attribute.
     *
     * @return int
     */
    public function getLanguageIdAttribute(): int
    {
        return $this->attributes['language_id'];
    }

    /**
     * Set the language_id attribute.
     *
     * @param int $value
     */
    public function setLanguageIdAttribute(int $value): void
    {
        $this->attributes['language_id'] = $value;
    }

    /**
     * Get the locale attribute.
     *
     * @return string
     */
    public function getLocaleAttribute(): string
    {
        return $this->attributes['locale'];
    }

    /**
     * Set the locale attribute.
     *
     * @param string $value
     */
    public function setLocaleAttribute(string $value): void
    {
        $this->attributes['locale'] = $value;
    }

    /**
     * Get the title attribute.
     *
     * @return string
     */
    public function getTitleAttribute(): string
    {
        return $this->attributes['title'];
    }

    /**
     * Set the title attribute.
     *
     * @param string $value
     */
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
    }
}
