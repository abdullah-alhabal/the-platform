<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Translation.
 *
 * @property int $id
 * @property string $language
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation query()
 *
 * @mixin \Eloquent
 */
final class Translation extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'language',
        'key',
        'value',
    ];

    /**
     * Accessor for the "language" attribute.
     */
    public function getLanguageAttribute(): string
    {
        return mb_strtoupper($this->attributes['language']);
    }

    /**
     * Mutator for the "language" attribute.
     */
    public function setLanguageAttribute(string $value): void
    {
        $this->attributes['language'] = mb_strtolower($value);
    }

    /**
     * Accessor for the "key" attribute.
     */
    public function getKeyAttribute(): string
    {
        return $this->attributes['key'];
    }

    /**
     * Mutator for the "key" attribute.
     */
    public function setKeyAttribute(string $value): void
    {
        $this->attributes['key'] = $value;
    }

    /**
     * Accessor for the "value" attribute.
     */
    public function getValueAttribute(): string
    {
        return $this->attributes['value'];
    }

    /**
     * Mutator for the "value" attribute.
     */
    public function setValueAttribute(string $value): void
    {
        $this->attributes['value'] = $value;
    }
}
