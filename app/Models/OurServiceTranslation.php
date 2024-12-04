<?php

declare(strict_types=1);

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class OurServiceTranslation.
 *
 * @property int $id
 * @property int $our_service_id
 * @property string $locale
 * @property string $title
 * @property string $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read OurService $ourService
 *
 * @method static Builder|OurServiceTranslation newModelQuery()
 * @method static Builder|OurServiceTranslation newQuery()
 * @method static Builder|OurServiceTranslation query()
 *
 * @mixin Eloquent
 */
final class OurServiceTranslation extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'our_service_id',
        'locale',
        'title',
        'text',
    ];

    /**
     * Get the OurService that owns the translation.
     *
     * @return BelongsTo
     */
    public function ourService(): BelongsTo
    {
        return $this->belongsTo(OurService::class);
    }

    // Accessors and Mutators

    /**
     * Get the our_service_id attribute.
     *
     * @return int
     */
    public function getOurServiceIdAttribute(): int
    {
        return $this->attributes['our_service_id'];
    }

    /**
     * Set the our_service_id attribute.
     *
     * @param int $ourServiceId
     */
    public function setOurServiceIdAttribute(int $ourServiceId): void
    {
        $this->attributes['our_service_id'] = $ourServiceId;
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
     * @param string $locale
     */
    public function setLocaleAttribute(string $locale): void
    {
        $this->attributes['locale'] = $locale;
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
     * @param string $title
     */
    public function setTitleAttribute(string $title): void
    {
        $this->attributes['title'] = $title;
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
     * @param string $text
     */
    public function setTextAttribute(string $text): void
    {
        $this->attributes['text'] = $text;
    }

    /**
     * Cast attributes to native types.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
