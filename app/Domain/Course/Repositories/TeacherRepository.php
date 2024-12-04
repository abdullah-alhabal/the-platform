<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\Models\Teacher;
use App\Domain\Course\Interfaces\TeacherRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class TeacherRepository implements TeacherRepositoryInterface
{
    protected Teacher $model;

    public function __construct(Teacher $model)
    {
        $this->model = $model;
    }

    public function findById(int $id): ?Teacher
    {
        return Cache::remember("teacher.{$id}", 3600, function () use ($id) {
            return $this->model->with(['courses'])->find($id);
        });
    }

    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        $query = $this->applyFilters($query, $filters);

        return $query->latest()->paginate($perPage);
    }

    public function getTopRated(int $limit = 6): Collection
    {
        return Cache::remember("teachers.top_rated.{$limit}", 3600, function () use ($limit) {
            return $this->model->active()
                ->withCount('courses')
                ->withAvg('courses.ratings', 'rating')
                ->orderByDesc('courses_ratings_avg_rating')
                ->take($limit)
                ->get();
        });
    }

    public function create(array $data): Teacher
    {
        $teacher = $this->model->create($data);
        $this->clearCache();
        return $teacher;
    }

    public function update(Teacher $teacher, array $data): bool
    {
        $updated = $teacher->update($data);
        if ($updated) {
            $this->clearCache($teacher);
        }
        return $updated;
    }

    public function delete(Teacher $teacher): bool
    {
        $deleted = $teacher->delete();
        if ($deleted) {
            $this->clearCache($teacher);
        }
        return $deleted;
    }

    public function getTeacherStats(Teacher $teacher): array
    {
        return [
            'total_courses' => $teacher->total_courses,
            'total_students' => $teacher->total_students,
            'average_rating' => $teacher->average_rating,
            'total_reviews' => $teacher->courses()->withCount('ratings')->get()->sum('ratings_count'),
            'revenue' => $teacher->courses()
                ->withSum('enrollments', 'paid_amount')
                ->get()
                ->sum('enrollments_sum_paid_amount'),
        ];
    }

    public function toggleActiveStatus(Teacher $teacher): bool
    {
        return $this->update($teacher, ['is_active' => !$teacher->is_active]);
    }

    public function searchByExpertise(string $expertise): Collection
    {
        return $this->model->active()
            ->where(function ($query) use ($expertise) {
                $query->whereJsonContains('expertise', $expertise)
                    ->orWhereJsonContains('expertise', strtolower($expertise))
                    ->orWhereJsonContains('expertise', ucfirst($expertise));
            })
            ->get();
    }

    protected function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('bio', 'like', "%{$filters['search']}%")
                    ->orWhere('expertise', 'like', "%{$filters['search']}%");
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['expertise'])) {
            $query->whereJsonContains('expertise', $filters['expertise']);
        }

        if (!empty($filters['min_rating'])) {
            $query->whereHas('courses', function ($q) use ($filters) {
                $q->having('average_rating', '>=', $filters['min_rating']);
            });
        }

        return $query;
    }

    protected function clearCache(?Teacher $teacher = null): void
    {
        if ($teacher) {
            Cache::forget("teacher.{$teacher->id}");
        }
        Cache::tags(['teachers'])->flush();
    }
} 