<?php

namespace App\Domain\Course\Interfaces;

use App\Domain\Course\Models\CourseEnrollment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface EnrollmentRepositoryInterface
{
    public function findById(int $id): ?CourseEnrollment;
    public function getStudentEnrollments(int $studentId, array $filters = []): Collection;
    public function getCourseEnrollments(int $courseId, array $filters = []): Collection;
    public function create(array $data): CourseEnrollment;
    public function update(CourseEnrollment $enrollment, array $data): bool;
    public function delete(CourseEnrollment $enrollment): bool;
    public function markAsCompleted(CourseEnrollment $enrollment): bool;
    public function updateProgress(CourseEnrollment $enrollment): bool;
    public function getActiveEnrollments(): Collection;
    public function getExpiredEnrollments(): Collection;
    public function getCompletedEnrollments(): Collection;
    public function getEnrollmentStats(CourseEnrollment $enrollment): array;
} 