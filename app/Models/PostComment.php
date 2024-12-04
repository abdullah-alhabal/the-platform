<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostComment.
 *
 * @property int $id
 * @property string $text
 * @property bool $is_published
 * @property int $post_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 * @property-read Post $post
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment query()
 *
 * @mixin \Eloquent
 */
final class PostComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'text',
        'is_published',
        'post_id',
        'user_id',
    ];

    /**
     * Get the user that owns the comment.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that the comment belongs to.
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // Accessors and Mutators

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
     * Get the is_published attribute.
     *
     * @return bool
     */
    public function getIsPublishedAttribute(): bool
    {
        return (bool) $this->attributes['is_published'];
    }

    /**
     * Set the is_published attribute.
     *
     * @param bool $is_published
     */
    public function setIsPublishedAttribute(bool $is_published): void
    {
        $this->attributes['is_published'] = $is_published;
    }

    /**
     * Get the post_id attribute.
     *
     * @return int
     */
    public function getPostIdAttribute(): int
    {
        return $this->attributes['post_id'];
    }

    /**
     * Set the post_id attribute.
     *
     * @param int $post_id
     */
    public function setPostIdAttribute(int $post_id): void
    {
        $this->attributes['post_id'] = $post_id;
    }

    /**
     * Get the user_id attribute.
     *
     * @return int
     */
    public function getUserIdAttribute(): int
    {
        return $this->attributes['user_id'];
    }

    /**
     * Set the user_id attribute.
     *
     * @param int $user_id
     */
    public function setUserIdAttribute(int $user_id): void
    {
        $this->attributes['user_id'] = $user_id;
    }

    /**
     * Cast attributes to native types.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
