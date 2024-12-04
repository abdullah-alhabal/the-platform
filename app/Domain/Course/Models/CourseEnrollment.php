<?php

namespace App\Domain\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseEnrollment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'student_id',
        'paid_amount',
        'payment_method',
        'payment_status',
        'enrolled_at',
        'expires_at',
        'status',
        'progress_percentage',
        'last_accessed_at',
    ];

    protected $casts = [
        'paid_amount' => 'decimal:2',
        'progress_percentage' => 'decimal:2',
        'enrolled_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_accessed_at' => 'datetime',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function lessonCompletions(): HasMany
    {
        return $this->hasMany(LessonCompletion::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && now()->isAfter($this->expires_at);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && !$this->isExpired();
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'progress_percentage' => 100,
        ]);
    }

    public function updateProgress(): void
    {
        $totalLessons = $this->course->sections()
            ->withCount('lessons')
            ->get()
            ->sum('lessons_count');

        if ($totalLessons === 0) {
            return;
        }

        $completedLessons = $this->lessonCompletions()->count();
        $progressPercentage = round(($completedLessons / $totalLessons) * 100, 2);

        $this->update([
            'progress_percentage' => $progressPercentage,
            'last_accessed_at' => now(),
        ]);

        if ($progressPercentage === 100) {
            $this->markAsCompleted();
        }
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
