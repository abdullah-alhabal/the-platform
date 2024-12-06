<?php

namespace App\Http\Controllers\Api\V1\Admin\Course;

use App\Domain\Course\Models\Course;
use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class ShowCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(Course $course): JsonResponse
    {
        // TODO: error handling
        $courseDetails = $this->courseService->getCourseDetails($course);

        return $this->successResponse(
            $courseDetails,
            'Course details retrieved successfully'
        );
    }
} 