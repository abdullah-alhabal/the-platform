<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\Interfaces\CourseRepositoryInterface;
use App\Domain\Course\Models\Course;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseRepository implements CourseRepositoryInterface
{
    public function __construct(
        private readonly Course $model,
        private readonly Cache $cache
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with(['teacher', 'sections.lessons']);

        if (isset($filters['level'])) {
            $query->where('level', $filters['level']);
        }

        if (isset($filters['teacher_id'])) {
            $query->where('teacher_id', $filters['teacher_id']);
        }

        if (isset($filters['is_published'])) {
            $query->where('is_published', $filters['is_published']);
        }

        if (isset($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (isset($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        return $query->latest()->paginate(15);
    }

    public function findById(int $id): ?Course
    {
        return $this->cache->remember("course.{$id}", 3600, function () use ($id): ?Course {
            return $this->model->with(['teacher', 'sections.lessons'])->find($id);
        });
    }

    public function findBySlug(string $slug): ?Course
    {
        return $this->cache->remember("course.slug.{$slug}", 3600, function () use ($slug): ?Course {
            return $this->model->with(['teacher', 'sections.lessons'])->where('slug', $slug)->first();
        });
    }

    public function create(array $data): Course
    {
        return $this->model->create($data);
    }

    public function update(Course $course, array $data): bool
    {
        return $course->update($data);
    }

    public function delete(Course $course): bool
    {
        return $course->delete();
    }

    public function getFeatured(int $limit = 6): Collection
    {
        return $this->cache->remember("courses.featured.{$limit}", 3600, function () use ($limit): Collection {
            return $this->model->with('teacher')
                ->where('is_published', true)
                ->orderBy('rating', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    public function getCourseStats(Course $course): array
    {
        return $this->cache->remember("course.{$course->id}.stats", 3600, function () use ($course): array {
            return [
                'total_students' => $course->enrollments()->count(),
                'total_lessons' => $course->lessons()->count(),
                'total_duration' => $course->lessons()->sum('duration'),
                'average_rating' => $course->ratings()->avg('rating'),
                'total_ratings' => $course->ratings()->count(),
            ];
        });
    }

    public function getCourseSections(Course $course): Collection
    {
        return $this->cache->remember("course.{$course->id}.sections", 3600, function () use ($course): Collection {
            return $course->sections()->with(['lessons' => function ($query) {
                $query->orderBy('order');
            }])->orderBy('order')->get();
        });
    }

    public function getCourseRatings(Course $course): LengthAwarePaginator
    {
        return $course->ratings()
            ->with(['user', 'replies.user'])
            ->latest()
            ->paginate(10);
    }

    public function search(string $query, array $filters = []): LengthAwarePaginator
    {
        $courseQuery = $this->model->with(['teacher', 'sections'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });

        if (isset($filters['level'])) {
            $courseQuery->where('level', $filters['level']);
        }

        if (isset($filters['teacher_id'])) {
            $courseQuery->where('teacher_id', $filters['teacher_id']);
        }

        if (isset($filters['is_published'])) {
            $courseQuery->where('is_published', $filters['is_published']);
        }

        if (isset($filters['price_min'])) {
            $courseQuery->where('price', '>=', $filters['price_min']);
        }

        if (isset($filters['price_max'])) {
            $courseQuery->where('price', '<=', $filters['price_max']);
        }

        return $courseQuery->latest()->paginate(15);
    }
}
