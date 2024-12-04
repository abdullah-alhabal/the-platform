<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read OurTeam|null $ourTeam
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OurTeamTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OurTeamTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OurTeamTranslation query()
 *
 * @mixin \Eloquent
 */
final class OurTeamTranslation extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'our_team_id',
        'locale',
        'name',
        'job',
        'description',
    ];

    public function ourTeam(): BelongsTo
    {
        return $this->belongsTo(OurTeam::class);
    }
}
