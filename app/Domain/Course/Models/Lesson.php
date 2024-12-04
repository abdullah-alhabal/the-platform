<?php

namespace App\Domain\Course\Models;

use App\Domain\Course\Enums\LessonType;
use App\Domain\Course\Interfaces\LessonableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_section_id',
        'title',
        'slug',
        'description',
        'type',
        'duration_minutes',
        'order',
        'is_free',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'type' => LessonType::class,
        'duration_minutes' => 'integer',
        'order' => 'integer',
        'is_free' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    public function lessonable(): MorphTo
    {
        return $this->morphTo();
    }

    public function completions(): HasMany
    {
        return $this->hasMany(LessonCompletion::class);
    }

    public function isCompletedBy($userId): bool
    {
        return $this->completions()
            ->whereHas('enrollment', function ($query) use ($userId) {
                $query->where('student_id', $userId);
            })
            ->exists();
    }

    public function getNextLesson(): ?self
    {
        return static::where('course_section_id', $this->course_section_id)
            ->where('order', '>', $this->order)
            ->orderBy('order')
            ->first();
    }

    public function getPreviousLesson(): ?self
    {
        return static::where('course_section_id', $this->course_section_id)
            ->where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }
}
