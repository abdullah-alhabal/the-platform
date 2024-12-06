<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\Interfaces\EnrollmentRepositoryInterface;
use App\Domain\Course\Models\CourseEnrollment;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function __construct(
        private readonly CourseEnrollment $model,
        private readonly Cache $cache
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with(['course', 'student']);

        if (isset($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        if (isset($filters['student_id'])) {
            $query->where('student_id', $filters['student_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate(15);
    }

    public function findById(int $id): ?CourseEnrollment
    {
        return $this->cache->remember("enrollment.{$id}", 3600, function () use ($id): ?CourseEnrollment {
            return $this->model->with(['course', 'student', 'lessonCompletions'])->find($id);
        });
    }

    public function create(array $data): CourseEnrollment
    {
        return $this->model->create($data);
    }

    public function update(CourseEnrollment $enrollment, array $data): bool
    {
        return $enrollment->update($data);
    }

    public function delete(CourseEnrollment $enrollment): bool
    {
        return $enrollment->delete();
    }

    public function getStudentEnrollments(int $studentId): LengthAwarePaginator
    {
        return $this->model->with(['course', 'lessonCompletions'])
            ->where('student_id', $studentId)
            ->latest()
            ->paginate(10);
    }

    public function getCourseEnrollments(int $courseId): LengthAwarePaginator
    {
        return $this->model->with(['student', 'lessonCompletions'])
            ->where('course_id', $courseId)
            ->latest()
            ->paginate(10);
    }

    public function checkEnrollmentExists(int $courseId, int $studentId): bool
    {
        return $this->model->where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->exists();
    }
} 