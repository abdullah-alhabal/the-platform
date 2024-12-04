<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PostCategoryTranslation.
 *
 * @property int $id
 * @property int $post_category_id
 * @property string $locale
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read PostCategory $postCategory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategoryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategoryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategoryTranslation query()
 *
 * @mixin \Eloquent
 */
final class PostCategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_category_id',
        'locale',
        'name',
        'description',
    ];

    /**
     * Get the post category that owns the translation.
     *
     * @return BelongsTo
     */
    public function postCategory(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    // Accessors and Mutators

    /**
     * Get the post_category_id attribute.
     *
     * @return int
     */
    public function getPostCategoryIdAttribute(): int
    {
        return $this->attributes['post_category_id'];
    }

    /**
     * Set the post_category_id attribute.
     *
     * @param int $postCategoryId
     */
    public function setPostCategoryIdAttribute(int $postCategoryId): void
    {
        $this->attributes['post_category_id'] = $postCategoryId;
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
     * Get the name attribute.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Set the name attribute.
     *
     * @param string $name
     */
    public function setNameAttribute(string $name): void
    {
        $this->attributes['name'] = $name;
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
