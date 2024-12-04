<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read PostCategory|null $category
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 *
 * @mixin \Eloquent
 */
final class Post extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'title',
        'content',
        'post_category_id',
        'image',
        'is_published',
        'date_publication',
        'user_id',
    ];

    /**
     * Relationship with PostCategory.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
}
