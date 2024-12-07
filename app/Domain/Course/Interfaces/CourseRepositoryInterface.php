<?php

namespace App\Domain\Course\Interfaces;

use App\Domain\Course\DTOs\Course\CourseStatisticsDto;
use App\Domain\Course\DTOs\Course\GetAllCoursesFilterDto;
use App\Domain\Course\DTOs\Course\SearchCourseFiltersDto;
use App\Domain\Course\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CourseRepositoryInterface
{
    public function getAllCourses(GetAllCoursesFilterDto $filters): LengthAwarePaginator;

    public function findCourseById(int $id): ?Course;

    public function findCourseBySlug(string $slug): ?Course;

    public function createCourse(array $data): Course;

    public function updateCourse(Course $course, array $data): bool;

    public function deleteCourse(Course $course): bool;

    public function getFeaturedCourses(int $limit = 6): Collection;

    public function getCourseStatistics(Course $course): CourseStatisticsDto;

    public function getCourseSections(Course $course): Collection;

    public function getCourseRatings(Course $course): LengthAwarePaginator;

    public function searchCourse(string $query, SearchCourseFiltersDto $filters): LengthAwarePaginator;
}
