<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class OurMessageTranslation.
 *
 * @property int $id
 * @property int $our_message_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read OurMessage $ourMessage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OurMessageTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OurMessageTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OurMessageTranslation query()
 *
 * @mixin \Eloquent
 */
final class OurMessageTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'our_message_id',
        'locale',
        'title',
        'description',
    ];

    /**
     * Get the OurMessage that owns the translation.
     *
     * @return BelongsTo
     */
    public function ourMessage(): BelongsTo
    {
        return $this->belongsTo(OurMessage::class);
    }

    // Accessors and Mutators

    /**
     * Get the our_message_id attribute.
     *
     * @return int
     */
    public function getOurMessageIdAttribute(): int
    {
        return $this->attributes['our_message_id'];
    }

    /**
     * Set the our_message_id attribute.
     *
     * @param int $ourMessageId
     */
    public function setOurMessageIdAttribute(int $ourMessageId): void
    {
        $this->attributes['our_message_id'] = $ourMessageId;
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
     * Get the description attribute.
     *
     * @return string|null
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->attributes['description'];
    }

    /**
     * Set the description attribute.
     *
     * @param string|null $description
     */
    public function setDescriptionAttribute(?string $description): void
    {
        $this->attributes['description'] = $description;
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
