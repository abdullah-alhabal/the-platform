<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OurTeamTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OurTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OurTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OurTeam onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OurTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OurTeam withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OurTeam withoutTrashed()
 *
 * @mixin \Eloquent
 */
final class OurTeam extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var array<int, string> */
    protected $fillable = [
        'image',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(OurTeamTranslation::class);
    }
}
