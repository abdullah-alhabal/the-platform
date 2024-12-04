<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read string $formatted_date
 * @property-read bool $is_read
 * @property-read string|null $read_at_formatted
 * @property-read \Illuminate\Database\Eloquent\Collection<int, VisitorMessageReply> $replies
 * @property-read int|null $replies_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorMessage query()
 *
 * @mixin \Eloquent
 */
final class VisitorMessage extends Model
{
    use HasFactory;

    public $translatable = [
        'subject',
        'text',
    ];

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'email',
        'read_at',
        'mobile',
        'code_country',
        'slug_country',
    ];

    public function markAsRead(): bool
    {
        return $this->update(['read_at' => now()]);
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('M d, Y H:i A');
    }

    public function getIsReadAttribute(): bool
    {
        return null !== $this->read_at;
    }

    public function getReadAtFormattedAttribute(): ?string
    {
        return $this->read_at?->format('M d, Y H:i A');
    }

    public function replies()
    {
        return $this->hasMany(VisitorMessageReply::class, 'message_id');
    }
}
