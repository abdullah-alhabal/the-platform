<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\File\FileService;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class OurService.
 *
 * @property int $id
 * @property string|null $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, OurServiceTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static Builder|OurService newModelQuery()
 * @method static Builder|OurService newQuery()
 * @method static Builder|OurService query()
 *
 * @mixin Eloquent
 */
final class OurService extends Model
{
    use HasFactory, SoftDeletes;

    /** @var array<int, string> */
    public array $translatedAttributes = [
        'title',
        'text',
    ];

    /** @var array<int, string> */
    protected $fillable = [
        'image',
    ];

    /**
     * Relationship with OurServiceTranslation.
     *
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(OurServiceTranslation::class);
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
