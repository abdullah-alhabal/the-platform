<?php

namespace App\Domain\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_enrollment_id',
        'lesson_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(CourseEnrollment::class, 'course_enrollment_id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    protected static function booted()
    {
        static::created(function ($completion) {
            $completion->enrollment->updateProgress();
        });

        static::deleted(function ($completion) {
            $completion->enrollment->updateProgress();
        });
    }

    public function scopeByStudent($query, int $studentId)
    {
        return $query->whereHas('enrollment', function ($q) use ($studentId) {
            $q->where('student_id', $studentId);
        });
    }

    public function scopeByCourse($query, int $courseId)
    {
        return $query->whereHas('enrollment', function ($q) use ($courseId) {
            $q->where('course_id', $courseId);
        });
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('completed_at', 'desc');
    }
} 