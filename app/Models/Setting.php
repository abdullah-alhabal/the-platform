<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $value
 *
 * @method static \Database\Factories\SettingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 *
 * @mixin \Eloquent
 */
final class Setting extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'key',
        'value',
    ];

    public function getValueAttribute($value)
    {
        return $value ?? '';
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = $value ?? null;
    }
}
