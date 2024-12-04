<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Faq.
 *
 * @property int $id
 * @property string $type
 * @property int $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FaqTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq filter($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faq withoutTrashed()
 *
 * @mixin \Eloquent
 */
final class Faq extends Model
{
    use HasFactory, SoftDeletes;

    /** @var array<int, string> */
    protected $fillable = ['type', 'order'];

    /**
     * Get the translations for the FAQ.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(FaqTranslation::class);
    }

    /**
     * Scope a query to filter FAQs based on search.
     *
     * @param mixed $query
     * @param mixed $search
     */
    public function scopeFilter($query, $search)
    {
        return $query->whereHas('translations', function ($q) use ($search): void {
            $q->where('title', 'like', '%' . $search . '%');
        });
    }

    // Accessors and Mutators

    /**
     * Get the type attribute.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return $this->attributes['type'];
    }

    /**
     * Set the type attribute.
     *
     * @param string $value
     */
    public function setTypeAttribute(string $value): void
    {
        $this->attributes['type'] = $value;
    }

    /**
     * Get the order attribute.
     *
     * @return int
     */
    public function getOrderAttribute(): int
    {
        return (int) $this->attributes['order'];
    }

    /**
     * Set the order attribute.
     *
     * @param int $value
     */
    public function setOrderAttribute(int $value): void
    {
        $this->attributes['order'] = $value;
    }
}
