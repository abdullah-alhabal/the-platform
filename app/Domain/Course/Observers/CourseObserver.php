<?php

namespace App\Domain\Course\Observers;

use App\Domain\Course\Models\Course;
use App\Domain\Course\Services\CourseService;

class CourseObserver
{
    public function __construct(
        private readonly CourseService $courseService
    ){}

    /**
     * Handle the Course "created" event.
     */
    public function created(Course $course)
    {
        $this->updatePublishStatus($course);
    }

    /**
     * Handle the Course "updated" event.
     */
    public function updated(Course $course)
    {
        $this->updatePublishStatus($course);
    }

    /**
     * Handle the Course "saved" event.
     */
    public function saved(Course $course)
    {
        // Optionally, we can handle saved here if needed, though we can rely on created and updated
        $this->updatePublishStatus($course);
    }

    /**
     * Updates the publish status of the course based on the criteria defined in CourseService.
     */
    private function updatePublishStatus(Course $course)
    {
        if ($this->courseService->canBePublished($course)) {
            $course->update(['is_published' => true]);
        } else {
            $course->update(['is_published' => false]);
        }
    }
}
