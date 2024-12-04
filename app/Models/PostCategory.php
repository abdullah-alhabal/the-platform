<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\File\FileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostCategory.
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $value
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, PostCategoryTranslation> $translations
 * @property-read int|null $translations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, PostCategory> $children
 * @property-read int|null $children_count
 * @property-read PostCategory|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Post> $posts
 * @property-read int|null $posts_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory query()
 *
 * @mixin \Eloquent
 */
final class PostCategory extends Model
{
    use HasFactory, SoftDeletes;

    public $translatedAttributes = [
        'name',
        'description',
    ];

    protected $fillable = [
        'parent_id',
        'value',
        'image',
    ];

    /**
     * Relationship with PostCategoryTranslation.
     *
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(PostCategoryTranslation::class);
    }

    /**
     * Relationship with child categories.
     *
     * @return HasMany<PostCategory>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Relationship with parent category.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Relationship with Posts.
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_category_id');
    }

    /**
     * Scope to filter categories by search.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string                                $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, string $search): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereHas('translations', function ($q) use ($search): void {
            $q->where('name', 'like', '%' . $search . '%');
        });
    }

    // Accessors and Mutators

    /**
     * Get the value attribute.
     *
     * @return string
     */
    public function getValueAttribute(): string
    {
        return $this->attributes['value'];
    }

    /**
     * Set the value attribute.
     *
     * @param string $value
     */
    public function setValueAttribute(string $value): void
    {
        $this->attributes['value'] = $value;
    }

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
     * Get the parent_id attribute.
     *
     * @return int|null
     */
    public function getParentIdAttribute(): ?int
    {
        return $this->attributes['parent_id'];
    }

    /**
     * Set the parent_id attribute.
     *
     * @param int|null $parentId
     */
    public function setParentIdAttribute(?int $parentId): void
    {
        $this->attributes['parent_id'] = $parentId;
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
