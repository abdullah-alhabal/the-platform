<?php

namespace App\Domain\Course\Services;

use App\Domain\Course\Models\Course;
use App\Domain\Course\Interfaces\CourseRepositoryInterface;
use App\Domain\Course\DTOs\CourseDTO;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class CourseService
{
    protected CourseRepositoryInterface $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function createCourse(array $data): Course
    {
        try {
            DB::beginTransaction();

            // Handle thumbnail upload if present
            if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
                $data['thumbnail'] = $this->uploadThumbnail($data['thumbnail']);
            }

            // Generate slug
            $data['slug'] = Str::slug($data['title']);

            // Create course
            $course = $this->courseRepository->create($data);

            DB::commit();

            return $course;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateCourse(Course $course, array $data): bool
    {
        try {
            DB::beginTransaction();

            // Handle thumbnail update if present
            if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
                // Delete old thumbnail
                if ($course->thumbnail) {
                    Storage::delete($course->thumbnail);
                }
                $data['thumbnail'] = $this->uploadThumbnail($data['thumbnail']);
            }

            // Update slug if title changed
            if (isset($data['title']) && $data['title'] !== $course->title) {
                $data['slug'] = Str::slug($data['title']);
            }

            // Update course
            $updated = $this->courseRepository->update($course, $data);

            DB::commit();

            return $updated;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteCourse(Course $course): bool
    {
        try {
            DB::beginTransaction();

            // Delete thumbnail if exists
            if ($course->thumbnail) {
                Storage::delete($course->thumbnail);
            }

            // Delete course
            $deleted = $this->courseRepository->delete($course);

            DB::commit();

            return $deleted;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function publishCourse(Course $course): bool
    {
        // Validate if course can be published
        if (!$this->canBePublished($course)) {
            throw new Exception('Course cannot be published. Please ensure it has all required content.');
        }

        return $this->courseRepository->updatePublishStatus($course, true);
    }

    public function unpublishCourse(Course $course): bool
    {
        return $this->courseRepository->updatePublishStatus($course, false);
    }

    public function getCourseDetails(Course $course): CourseDTO
    {
        // Increment view count
        $this->courseRepository->incrementViews($course);

        // Get related courses
        $relatedCourses = $this->courseRepository->getRelated($course);

        // Transform to DTO
        return new CourseDTO($course, $relatedCourses);
    }

    protected function uploadThumbnail($file): string
    {
        $path = $file->store('course-thumbnails', 'public');
        return Storage::url($path);
    }

    protected function canBePublished(Course $course): bool
    {
        // Check if course has required content
        return $course->sections()
            ->whereHas('lessons', function ($query) {
                $query->where('is_published', true);
            })
            ->exists()
            && $course->title
            && $course->description
            && $course->price >= 0;
    }
}
