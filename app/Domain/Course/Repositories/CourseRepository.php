<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\DTOs\Course\CourseStatisticsDto;
use App\Domain\Course\DTOs\Course\GetAllCoursesFilterDto;
use App\Domain\Course\DTOs\Course\SearchCourseFiltersDto;
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

    public function getAllCourses(GetAllCoursesFilterDto $filters): LengthAwarePaginator
    {
        $query = $this->model->with(['teacher', 'sections.lessons']);

        if ($filters->level) {
            $query->where('level', $filters->level);
        }

        if ($filters->teacherId) {
            $query->where('teacher_id', $filters->teacherId);
        }

        if ($filters->isPublished !== null) {
            $query->where('is_published', $filters->isPublished);
        }

        if ($filters->priceMin !== null) {
            $query->where('price', '>=', $filters->priceMin);
        }

        if ($filters->priceMax !== null) {
            $query->where('price', '<=', $filters->priceMax);
        }

        return $query->latest()->paginate(15);
    }

    public function findCourseById(int $id): ?Course
    {
        return $this->cache->remember("course.{$id}", 3600, function () use ($id): ?Course {
            return $this->model->with(['teacher', 'sections.lessons'])->find($id);
        });
    }

    public function findCourseBySlug(string $slug): ?Course
    {
        return $this->cache->remember("course.slug.{$slug}", 3600, function () use ($slug): ?Course {
            return $this->model->with(['teacher', 'sections.lessons'])->where('slug', $slug)->first();
        });
    }

    public function createCourse(array $data): Course
    {
        return $this->model->create($data);
    }

    public function updateCourse(Course $course, array $data): bool
    {
        return $course->update($data);
    }

    public function deleteCourse(Course $course): bool
    {
        return $course->delete();
    }

    public function getFeaturedCourses(int $limit = 6): Collection
    {
        return $this->cache->remember("courses.featured.{$limit}", 3600, function () use ($limit): Collection {
            return $this->model->with('teacher')
                ->where('is_published', true)
                ->orderBy('rating', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    public function getCourseStatistics(Course $course): CourseStatisticsDto
    {
        $stats = $this->cache->remember("course.{$course->id}.stats", 3600, function () use ($course) {
            return [
                'total_students' => $course->enrollments()->count(),
                'total_lessons' => $course->sections()->withCount('lessons')->get()->sum('lessons_count'),
                'total_duration' => $course->sections()->with('lessons')->get()->flatMap(fn($section) => $section->lessons)->sum('duration'),
                'average_rating' => $course->ratings()->avg('rating') ?? 0.0,
                'total_ratings' => $course->ratings()->count(),
            ];
        });

        return CourseStatisticsDto::fromArray($stats);
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

    public function searchCourse(string $query, SearchCourseFiltersDto $filters): LengthAwarePaginator
    {
        $courseQuery = $this->model->with(['teacher', 'sections'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });

        if ($filters->level) {
            $courseQuery->where('level', $filters->level);
        }

        if ($filters->teacherId) {
            $courseQuery->where('teacher_id', $filters->teacherId);
        }

        if (!is_null($filters->isPublished)) {
            $courseQuery->where('is_published', $filters->isPublished);
        }

        if ($filters->priceMin) {
            $courseQuery->where('price', '>=', $filters->priceMin);
        }

        if ($filters->priceMax) {
            $courseQuery->where('price', '<=', $filters->priceMax);
        }

        return $courseQuery->latest()->paginate(15);
    }
}
