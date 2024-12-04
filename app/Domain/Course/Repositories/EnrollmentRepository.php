<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\Models\CourseEnrollment;
use App\Domain\Course\Interfaces\EnrollmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    protected CourseEnrollment $model;

    public function __construct(CourseEnrollment $model)
    {
        $this->model = $model;
    }

    public function findById(int $id): ?CourseEnrollment
    {
        return Cache::remember("enrollment.{$id}", 3600, function () use ($id) {
            return $this->model->with(['course', 'student', 'lessonCompletions'])->find($id);
        });
    }

    public function getStudentEnrollments(int $studentId, array $filters = []): Collection
    {
        $query = $this->model->where('student_id', $studentId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        if (isset($filters['is_expired'])) {
            if ($filters['is_expired']) {
                $query->where('expires_at', '<=', now());
            } else {
                $query->where(function ($q) {
                    $q->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                });
            }
        }

        return $query->with(['course', 'lessonCompletions'])->get();
    }

    public function getCourseEnrollments(int $courseId, array $filters = []): Collection
    {
        $query = $this->model->where('course_id', $courseId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['progress_min'])) {
            $query->where('progress_percentage', '>=', $filters['progress_min']);
        }

        if (isset($filters['progress_max'])) {
            $query->where('progress_percentage', '<=', $filters['progress_max']);
        }

        return $query->with(['student', 'lessonCompletions'])->get();
    }

    public function create(array $data): CourseEnrollment
    {
        $data['enrolled_at'] = $data['enrolled_at'] ?? now();
        $enrollment = $this->model->create($data);
        $this->clearCache();
        return $enrollment;
    }

    public function update(CourseEnrollment $enrollment, array $data): bool
    {
        $updated = $enrollment->update($data);
        if ($updated) {
            $this->clearCache($enrollment);
        }
        return $updated;
    }

    public function delete(CourseEnrollment $enrollment): bool
    {
        $deleted = $enrollment->delete();
        if ($deleted) {
            $this->clearCache($enrollment);
        }
        return $deleted;
    }

    public function markAsCompleted(CourseEnrollment $enrollment): bool
    {
        return $this->update($enrollment, [
            'status' => 'completed',
            'progress_percentage' => 100,
        ]);
    }

    public function updateProgress(CourseEnrollment $enrollment): bool
    {
        $enrollment->updateProgress();
        $this->clearCache($enrollment);
        return true;
    }

    public function getActiveEnrollments(): Collection
    {
        return $this->model->active()->with(['course', 'student'])->get();
    }

    public function getExpiredEnrollments(): Collection
    {
        return $this->model->expired()->with(['course', 'student'])->get();
    }

    public function getCompletedEnrollments(): Collection
    {
        return $this->model->completed()->with(['course', 'student'])->get();
    }

    public function getEnrollmentStats(CourseEnrollment $enrollment): array
    {
        $lessonCompletions = $enrollment->lessonCompletions()
            ->orderBy('completed_at')
            ->get();

        $firstCompletion = $lessonCompletions->first()?->completed_at;
        $lastCompletion = $lessonCompletions->last()?->completed_at;

        $studyDuration = $firstCompletion && $lastCompletion
            ? $firstCompletion->diffInDays($lastCompletion)
            : 0;

        return [
            'progress_percentage' => $enrollment->progress_percentage,
            'completed_lessons' => $lessonCompletions->count(),
            'total_lessons' => $enrollment->course->sections()
                ->withCount('lessons')
                ->get()
                ->sum('lessons_count'),
            'study_duration_days' => $studyDuration,
            'last_accessed' => $enrollment->last_accessed_at?->diffForHumans(),
            'days_until_expiry' => $enrollment->expires_at
                ? now()->diffInDays($enrollment->expires_at, false)
                : null,
            'completion_rate' => $this->calculateCompletionRate($lessonCompletions),
        ];
    }

    protected function calculateCompletionRate(Collection $completions): ?float
    {
        if ($completions->isEmpty()) {
            return null;
        }

        $firstCompletion = $completions->first()->completed_at;
        $lastCompletion = $completions->last()->completed_at;
        $daysDiff = $firstCompletion->diffInDays($lastCompletion) ?: 1;

        return round($completions->count() / $daysDiff, 2);
    }

    protected function clearCache(?CourseEnrollment $enrollment = null): void
    {
        if ($enrollment) {
            Cache::forget("enrollment.{$enrollment->id}");
        }
        Cache::tags(['enrollments'])->flush();
    }
} 