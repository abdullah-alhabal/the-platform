<?php

namespace App\Domain\Course\Interfaces;

use App\Domain\Course\Models\Teacher;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TeacherRepositoryInterface
{
    public function findById(int $id): ?Teacher;
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function getTopRated(int $limit = 6): Collection;
    public function create(array $data): Teacher;
    public function update(Teacher $teacher, array $data): bool;
    public function delete(Teacher $teacher): bool;
    public function getTeacherStats(Teacher $teacher): array;
    public function toggleActiveStatus(Teacher $teacher): bool;
    public function searchByExpertise(string $expertise): Collection;
} 