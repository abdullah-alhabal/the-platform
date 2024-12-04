<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Language.
 *
 * @property int $id
 * @property string $title
 * @property string $lang
 * @property bool $is_default
 * @property bool $is_rtl
 * @property bool $is_active
 * @property bool $can_delete
 * @property-read \Illuminate\Database\Eloquent\Collection<int, LanguageTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language withoutTrashed()
 *
 * @mixin \Eloquent
 */
final class Language extends Model
{
    use HasFactory, SoftDeletes;

    /** @var array<int, string> */
    protected $fillable = [
        'title',
        'lang',
        'is_default',
        'is_rtl',
        'is_active',
        'can_delete',
    ];

    /**
     * Get the translations for the language.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(LanguageTranslation::class);
    }

    // Accessors and Mutators

    /**
     * Get the title attribute.
     *
     * @return string
     */
    public function getTitleAttribute(): string
    {
        return $this->attributes['title'];
    }

    /**
     * Set the title attribute.
     *
     * @param string $value
     */
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
    }

    /**
     * Get the lang attribute.
     *
     * @return string
     */
    public function getLangAttribute(): string
    {
        return $this->attributes['lang'];
    }

    /**
     * Set the lang attribute.
     *
     * @param string $value
     */
    public function setLangAttribute(string $value): void
    {
        $this->attributes['lang'] = $value;
    }

    /**
     * Get the is_default attribute.
     *
     * @return bool
     */
    public function getIsDefaultAttribute(): bool
    {
        return (bool) $this->attributes['is_default'];
    }

    /**
     * Set the is_default attribute.
     *
     * @param bool $value
     */
    public function setIsDefaultAttribute(bool $value): void
    {
        $this->attributes['is_default'] = $value;
    }

    /**
     * Get the is_rtl attribute.
     *
     * @return bool
     */
    public function getIsRtlAttribute(): bool
    {
        return (bool) $this->attributes['is_rtl'];
    }

    /**
     * Set the is_rtl attribute.
     *
     * @param bool $value
     */
    public function setIsRtlAttribute(bool $value): void
    {
        $this->attributes['is_rtl'] = $value;
    }

    /**
     * Get the is_active attribute.
     *
     * @return bool
     */
    public function getIsActiveAttribute(): bool
    {
        return (bool) $this->attributes['is_active'];
    }

    /**
     * Set the is_active attribute.
     *
     * @param bool $value
     */
    public function setIsActiveAttribute(bool $value): void
    {
        $this->attributes['is_active'] = $value;
    }

    /**
     * Get the can_delete attribute.
     *
     * @return bool
     */
    public function getCanDeleteAttribute(): bool
    {
        return (bool) $this->attributes['can_delete'];
    }

    /**
     * Set the can_delete attribute.
     *
     * @param bool $value
     */
    public function setCanDeleteAttribute(bool $value): void
    {
        $this->attributes['can_delete'] = $value;
    }
}
