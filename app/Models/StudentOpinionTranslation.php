<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class StudentOpinionTranslation.
 *
 * @property int $id
 * @property int $student_opinion_id
 * @property string $locale
 * @property string $name
 * @property string|null $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read StudentOpinion $studentOpinion
 *
 * @method static \Illuminate\Database\Eloquent\Builder|StudentOpinionTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentOpinionTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentOpinionTranslation query()
 *
 * @mixin \Eloquent
 */
final class StudentOpinionTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['student_opinion_id', 'locale', 'name', 'text'];

    /**
     * Get the StudentOpinion that owns the translation.
     *
     * @return BelongsTo
     */
    public function studentOpinion(): BelongsTo
    {
        return $this->belongsTo(StudentOpinion::class);
    }

    // Accessors and Mutators

    /**
     * Get the student_opinion_id attribute.
     *
     * @return int
     */
    public function getStudentOpinionIdAttribute(): int
    {
        return $this->attributes['student_opinion_id'];
    }

    /**
     * Set the student_opinion_id attribute.
     *
     * @param int $studentOpinionId
     */
    public function setStudentOpinionIdAttribute(int $studentOpinionId): void
    {
        $this->attributes['student_opinion_id'] = $studentOpinionId;
    }

    /**
     * Get the locale attribute.
     *
     * @return string
     */
    public function getLocaleAttribute(): string
    {
        return $this->attributes['locale'];
    }

    /**
     * Set the locale attribute.
     *
     * @param string $locale
     */
    public function setLocaleAttribute(string $locale): void
    {
        $this->attributes['locale'] = $locale;
    }

    /**
     * Get the name attribute.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Set the name attribute.
     *
     * @param string $name
     */
    public function setNameAttribute(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    /**
     * Get the text attribute.
     *
     * @return string|null
     */
    public function getTextAttribute(): ?string
    {
        return $this->attributes['text'];
    }

    /**
     * Set the text attribute.
     *
     * @param string|null $text
     */
    public function setTextAttribute(?string $text): void
    {
        $this->attributes['text'] = $text;
    }

    /**
     * Cast attributes to native types.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
