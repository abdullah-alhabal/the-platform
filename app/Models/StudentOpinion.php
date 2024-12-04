<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\File\FileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StudentOpinion.
 *
 * @property int $id
 * @property int|null $rate
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StudentOpinionTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|StudentOpinion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentOpinion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentOpinion query()
 *
 * @mixin \Eloquent
 */
final class StudentOpinion extends Model
{
    use HasFactory;
    use SoftDeletes;

    public array $translatedAttributes = ['name', 'text'];

    protected $fillable = ['rate', 'image'];

    /**
     * Relationship with StudentOpinionTranslation.
     *
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(StudentOpinionTranslation::class);
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
            'rate' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
