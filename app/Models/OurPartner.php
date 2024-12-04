<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class OurPartner extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    public array $translatedAttributes = [
        'title',
    ];

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'link',
    ];

    /**
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(OurPartner::class);
    }

    /**
     * Scope for filtering partners by translation title.
     *
     * @param mixed $query
     * @param mixed $search
     */
    public function scopeFilter($query, $search)
    {
        return $query->whereHas('translations', static function ($query) use ($search): void {
            $query->where('title', 'like', "%{$search}%");
        });
    }
}
