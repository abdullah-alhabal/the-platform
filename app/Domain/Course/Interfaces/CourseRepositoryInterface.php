<?php

namespace App\Domain\Course\Interfaces;

use App\Domain\Course\Models\Course;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepositoryInterface
{
    public function findById(int $id): ?Course;
    public function findBySlug(string $slug): ?Course;
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function getFeatured(int $limit = 6): Collection;
    public function getByTeacher(int $teacherId, array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): Course;
    public function update(Course $course, array $data): bool;
    public function delete(Course $course): bool;
    public function getRelated(Course $course, int $limit = 3): Collection;
    public function incrementViews(Course $course): void;
    public function updatePublishStatus(Course $course, bool $status): bool;
}
