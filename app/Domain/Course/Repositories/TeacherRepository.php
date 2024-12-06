<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\Interfaces\TeacherRepositoryInterface;
use App\Domain\Course\Models\Teacher;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function __construct(
        private readonly Teacher $model,
        private readonly Cache $cache
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with(['courses']);

        if (isset($filters['expertise'])) {
            $query->where('expertise', 'like', "%{$filters['expertise']}%");
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate(15);
    }

    public function findById(int $id): ?Teacher
    {
        return $this->cache->remember("teacher.{$id}", 3600, function () use ($id): ?Teacher {
            return $this->model->with(['courses'])->find($id);
        });
    }

    public function create(array $data): Teacher
    {
        return $this->model->create($data);
    }

    public function update(Teacher $teacher, array $data): bool
    {
        return $teacher->update($data);
    }

    public function delete(Teacher $teacher): bool
    {
        return $teacher->delete();
    }

    public function getTopRated(int $limit = 6): Collection
    {
        return $this->cache->remember("teachers.top_rated.{$limit}", 3600, function () use ($limit): Collection {
            return $this->model->active()
                ->withAvg('courses', 'rating')
                ->orderByDesc('courses_avg_rating')
                ->limit($limit)
                ->get();
        });
    }

    public function searchByExpertise(string $expertise): Collection
    {
        return $this->model->active()
            ->where('expertise', 'like', "%{$expertise}%")
            ->orderBy('name')
            ->get();
    }
} 