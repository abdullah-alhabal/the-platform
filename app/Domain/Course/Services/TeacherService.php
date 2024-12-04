<?php

namespace App\Domain\Course\Services;

use App\Domain\Course\DTOs\Teacher\CreateTeacherDto;
use App\Domain\Course\DTOs\Teacher\UpdateTeacherDto;
use App\Domain\Course\Models\Teacher;
use App\Domain\Course\Repositories\TeacherRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TeacherService
{
    public function __construct(
        private readonly TeacherRepository $teacherRepository
    ) {}

    public function getAllTeachers(array $filters = []): LengthAwarePaginator
    {
        return $this->teacherRepository->getAll($filters);
    }

    public function createTeacher(CreateTeacherDto $dto): Teacher
    {
        return $this->teacherRepository->create($dto->toArray());
    }

    public function updateTeacher(Teacher $teacher, UpdateTeacherDto $dto): bool
    {
        return $this->teacherRepository->update($teacher, $dto->toArray());
    }

    public function deleteTeacher(Teacher $teacher): bool
    {
        return $this->teacherRepository->delete($teacher);
    }

    public function getTeacherDetails(Teacher $teacher): array
    {
        $stats = $this->teacherRepository->getTeacherStats($teacher);
        return [
            ...$teacher->toArray(),
            'stats' => $stats,
        ];
    }

    public function findTeachersByExpertise(string $expertise): array
    {
        return $this->teacherRepository->searchByExpertise($expertise)->toArray();
    }

    public function getTopRatedTeachers(int $limit = 6): array
    {
        return $this->teacherRepository->getTopRated($limit)->toArray();
    }

    public function toggleTeacherStatus(Teacher $teacher): bool
    {
        return $this->teacherRepository->update($teacher, [
            'is_active' => !$teacher->is_active,
        ]);
    }
} 