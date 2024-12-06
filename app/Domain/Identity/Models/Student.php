<?php

namespace App\Domain\Identity\Models;

use App\Domain\Course\Models\CourseEnrollment;
use App\Domain\Course\Models\CourseRating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'education_level',
        'date_of_birth',
        'interests',
        'bio',
        'last_course_access_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'interests' => 'array',
        'last_course_access_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(CourseRating::class);
    }

    public function getActiveEnrollmentsCount(): int
    {
        return $this->enrollments()
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->count();
    }

    public function getCompletedCoursesCount(): int
    {
        return $this->enrollments()
            ->where('status', 'completed')
            ->count();
    }

    public function getAverageProgress(): float
    {
        return $this->enrollments()
            ->where('status', 'active')
            ->avg('progress_percentage') ?? 0.0;
    }

    public function updateLastCourseAccess(): void
    {
        $this->update(['last_course_access_at' => now()]);
    }
} 