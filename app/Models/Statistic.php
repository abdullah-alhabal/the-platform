<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\File\FileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OurMessage.
 *
 * @property int $id
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OurMessageTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OurMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OurMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OurMessage query()
 *
 * @mixin \Eloquent
 */
final class Statistic extends Model
{
    use HasFactory, SoftDeletes;

    public array $translatedAttributes = [
        'title',
    ];

    protected $fillable = [
        'image',
        'count',
    ];

    /**
     * Relationship with OurMessageTranslation.
     *
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(OurMessageTranslation::class);
    }

    // Accessors and Mutators

    /**
     * Get the image attribute.
     *
     * @return string|null
     */
    public function getImageAttribute(): ?string
    {
        return app(FileService::class)->getFullUrl($this->attributes['image']);
    }

    /**
     * Set the image attribute.
     *
     * @param string|null $image
     */
    public function setImageAttribute(?string $image): void
    {
        $this->attributes['image'] = $image;
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
            'deleted_at' => 'datetime',
        ];
    }
}
