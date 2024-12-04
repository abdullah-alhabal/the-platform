<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Admin|null $admin
 * @property-read VisitorMessage|null $message
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorMessageReply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorMessageReply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorMessageReply query()
 *
 * @mixin \Eloquent
 */
final class VisitorMessageReply extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'message_id',
        'admin_id',
        'content',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(VisitorMessage::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
