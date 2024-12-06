<?php

namespace App\Domain\Course\Services;

use App\Domain\Course\DTOs\Course\CreateCourseDto;
use App\Domain\Course\DTOs\Course\UpdateCourseDto;
use App\Domain\Course\Models\Course;
use App\Domain\Course\Repositories\CourseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseService
{
    public function __construct(
        private readonly CourseRepository $courseRepository
    ) {}

    public function getAllCourses(array $filters = []): LengthAwarePaginator
    {
        return $this->courseRepository->getAll($filters);
    }

    public function createCourse(CreateCourseDto $dto): Course
    {
        return $this->courseRepository->create($dto->toArray());
    }

    public function updateCourse(Course $course, UpdateCourseDto $dto): bool
    {
        return $this->courseRepository->update($course, $dto->toArray());
    }

    public function deleteCourse(Course $course): bool
    {
        return $this->courseRepository->delete($course);
    }

    public function getCourseDetails(Course $course): array
    {
        $stats = $this->courseRepository->getCourseStats($course);
        $sections = $this->courseRepository->getCourseSections($course);
        $ratings = $this->courseRepository->getCourseRatings($course);

        return [
            ...$course->toArray(),
            'stats' => $stats,
            'sections' => $sections,
            'ratings' => $ratings,
        ];
    }

    public function publishCourse(Course $course): bool
    {
        // Validate course is ready for publishing
        if (!$this->canBePublished($course)) {
            return false;
        }

        return $this->courseRepository->update($course, ['is_published' => true]);
    }

    public function unpublishCourse(Course $course): bool
    {
        return $this->courseRepository->update($course, ['is_published' => false]);
    }

    public function searchCourses(string $query, array $filters = []): LengthAwarePaginator
    {
        return $this->courseRepository->search($query, $filters);
    }

    private function canBePublished(Course $course): bool
    {
        // Course must have at least one section
        if ($course->sections()->count() === 0) {
            return false;
        }

        // Course must have at least one lesson
        if ($course->lessons()->count() === 0) {
            return false;
        }

        // Course must have a title, description, and price
        if (empty($course->title) || empty($course->description) || $course->price === null) {
            return false;
        }

        // Course must have requirements and learning outcomes
        if (empty($course->requirements) || empty($course->learning_outcomes)) {
            return false;
        }

        return true;
    }
}
