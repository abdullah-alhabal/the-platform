<?php

namespace App\Http\Controllers\Api\V1\Course;

use App\Domain\Course\Events\Course\CourseDeleted;
use App\Domain\Course\Models\Course;
use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class DeleteCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(Course $course): JsonResponse
    {
        $deleted = $this->courseService->deleteCourse($course);

        if ($deleted) {
            CourseDeleted::dispatch($course);
            return $this->successResponse(null, 'Course deleted successfully');
        }

        return $this->errorResponse('Failed to delete course');
    }
} 