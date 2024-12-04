<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Page|null $page
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageTranslation query()
 *
 * @mixin \Eloquent
 */
final class PageTranslation extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'page_id',
        'locale',
        'title',
        'text',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
