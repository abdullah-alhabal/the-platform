<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class FaqTranslation.
 *
 * @property int $id
 * @property int $faq_id
 * @property string $locale
 * @property string $title
 * @property string $text
 * @property-read Faq $faq
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FaqTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqTranslation query()
 *
 * @mixin \Eloquent
 */
final class FaqTranslation extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'faq_id',
        'locale',
        'title',
        'text',
    ];

    /**
     * Get the FAQ that owns the translation.
     *
     * @return BelongsTo
     */
    public function faq(): BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }

    // Accessors and Mutators

    /**
     * Get the faq_id attribute.
     *
     * @return int
     */
    public function getFaqIdAttribute(): int
    {
        return $this->attributes['faq_id'];
    }

    /**
     * Set the faq_id attribute.
     *
     * @param int $value
     */
    public function setFaqIdAttribute(int $value): void
    {
        $this->attributes['faq_id'] = $value;
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

    /**
     * Get the text attribute.
     *
     * @return string
     */
    public function getTextAttribute(): string
    {
        return $this->attributes['text'];
    }

    /**
     * Set the text attribute.
     *
     * @param string $value
     */
    public function setTextAttribute(string $value): void
    {
        $this->attributes['text'] = $value;
    }
}
