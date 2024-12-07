    <?php

    namespace App\Domain\Course\Services;

    use App\Domain\Course\DTOs\Course\CourseDetailsDto;
    use App\Domain\Course\DTOs\Course\CreateCourseDto;
    use App\Domain\Course\DTOs\Course\GetAllCoursesFilterDto;
    use App\Domain\Course\DTOs\Course\SearchCourseFiltersDto;
    use App\Domain\Course\DTOs\Course\UpdateCourseDto;
    use App\Domain\Course\Models\Course;
    use App\Domain\Course\Repositories\CourseRepository;
    use Illuminate\Pagination\LengthAwarePaginator;

    // we must improve the class by adding error handling, Dtos like (Course Filter of get all courses dto class) and the same for the search method and we must add error handling
    class CourseService
    {
        public function __construct(
            private readonly CourseRepository $courseRepository
        ) {}

        public function getAllCourses(GetAllCoursesFilterDto $filters): LengthAwarePaginator
        {
            return $this->courseRepository->getAllCourses($filters);
        }

        public function createCourse(CreateCourseDto $dto): Course
        {
            return $this->courseRepository->createCourse($dto->toArray());
        }

        public function updateCourse(Course $course, UpdateCourseDto $dto): bool
        {
            return $this->courseRepository->updateCourse($course, $dto->toArray());
        }

        public function deleteCourse(Course $course): bool
        {
            return $this->courseRepository->deleteCourse($course);
        }

        public function getCourseDetails(Course $course): CourseDetailsDto
        {
            try {
                $statisticsDto  = $this->courseRepository->getCourseStatistics($course);
                $sections = $this->courseRepository->getCourseSections($course);
                $ratings = $this->courseRepository->getCourseRatings($course);

                return new CourseDetailsDto(
                    statistics: $statisticsDto,
                    sections: $sections,
                    ratings: $ratings,
                    course: $course->toArray()
                );
            } catch (\Exception $e) {
                // Log the error or handle it as needed
                throw new \RuntimeException("Failed to retrieve course details: " . $e->getMessage());
            }
        }

        public function publishCourse(Course $course): bool
        {
            if (!$this->canBePublished($course)) {
                return false;
            }

            return $this->courseRepository->updateCourse($course, ['is_published' => true]);
        }

        public function unpublishCourse(Course $course): bool
        {
            return $this->courseRepository->updateCourse($course, ['is_published' => false]);
        }

        public function searchCourses(string $query, array $filters = []): LengthAwarePaginator
        {
            try {
                $filterDto = SearchCourseFiltersDto::fromArray($filters);
                return $this->courseRepository->searchCourse($query, $filterDto);
            } catch (\Exception $e) {
                throw $e;
            }
        }

        private function canBePublished(Course $course): bool
        {
            return $this->hasSections($course) &&
                $this->hasLessons($course) &&
                $this->hasTitleDescriptionAndPrice($course) &&
                $this->hasRequirementsAndOutcomes($course);
        }

        private function hasSections(Course $course): bool
        {
            // Use the published scope to check if there are any published sections
            return $course->sections()->published()->exists();
        }

        private function hasLessons(Course $course): bool
        {
            // Check if the course has at least one published lesson
            return $course->lessons()->published()->exists();
        }

        private function hasTitleDescriptionAndPrice(Course $course): bool
        {
            // Ensure the course has a title, description, and price
            return !empty($course->title) &&
                !empty($course->description) &&
                $course->price !== null;
        }

        private function hasRequirementsAndOutcomes(Course $course): bool
        {
            // Ensure the course has requirements and learning outcomes
            return !empty($course->requirements) &&
                !empty($course->objectives); // Assuming 'learning_outcomes' is stored as 'objectives'
        }
    }
