<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\Models\Course;
use App\Domain\Course\Interfaces\CourseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class CourseRepository implements CourseRepositoryInterface
{
    protected Course $model;

    public function __construct(Course $model)
    {
        $this->model = $model;
    }

    public function findById(int $id): ?Course
    {
        return Cache::remember("course.{$id}", 3600, function () use ($id) {
            return $this->model->with(['teacher', 'sections.lessons'])->find($id);
        });
    }

    public function findBySlug(string $slug): ?Course
    {
        return Cache::remember("course.slug.{$slug}", 3600, function () use ($slug) {
            return $this->model->with(['teacher', 'sections.lessons'])->where('slug', $slug)->first();
        });
    }

    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with('teacher')->published();

        $query = $this->applyFilters($query, $filters);

        return $query->latest()->paginate($perPage);
    }

    public function getFeatured(int $limit = 6): Collection
    {
        return Cache::remember("courses.featured.{$limit}", 3600, function () use ($limit) {
            return $this->model->with('teacher')
                ->published()
                ->featured()
                ->latest()
                ->take($limit)
                ->get();
        });
    }

    public function getByTeacher(int $teacherId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->where('teacher_id', $teacherId);

        $query = $this->applyFilters($query, $filters);

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data): Course
    {
        $course = $this->model->create($data);
        $this->clearCache($course);
        return $course;
    }

    public function update(Course $course, array $data): bool
    {
        $updated = $course->update($data);
        if ($updated) {
            $this->clearCache($course);
        }
        return $updated;
    }

    public function delete(Course $course): bool
    {
        $deleted = $course->delete();
        if ($deleted) {
            $this->clearCache($course);
        }
        return $deleted;
    }

    public function getRelated(Course $course, int $limit = 3): Collection
    {
        return $this->model->published()
            ->where('id', '!=', $course->id)
            ->where(function ($query) use ($course) {
                $query->where('level', $course->level)
                    ->orWhere('language', $course->language);
            })
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    public function incrementViews(Course $course): void
    {
        // Assuming you have a views column, or using a separate table for analytics
        $course->increment('views');
        $this->clearCache($course);
    }

    public function updatePublishStatus(Course $course, bool $status): bool
    {
        $updated = $course->update([
            'is_published' => $status,
            'published_at' => $status ? now() : null,
        ]);

        if ($updated) {
            $this->clearCache($course);
        }

        return $updated;
    }

    protected function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                    ->orWhere('description', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['level'])) {
            $query->where('level', $filters['level']);
        }

        if (!empty($filters['language'])) {
            $query->where('language', $filters['language']);
        }

        if (isset($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (isset($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        if (isset($filters['is_featured'])) {
            $query->where('is_featured', $filters['is_featured']);
        }

        return $query;
    }

    protected function clearCache(Course $course): void
    {
        Cache::forget("course.{$course->id}");
        Cache::forget("course.slug.{$course->slug}");
        Cache::tags(['courses'])->flush();
    }
}
