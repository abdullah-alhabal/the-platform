<?php

namespace App\Http\Controllers\Api\V1\Admin\Course;

use App\Domain\Course\Models\Course;
use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ShowCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(Course $course): JsonResponse
    {
        try {
            $courseDetails = $this->courseService->getCourseDetails($course);

            return $this->successResponse(
                $courseDetails->toArray(),
                'Course details retrieved successfully'
            );
        } catch (\RuntimeException $e) {
            // Log the error for further investigation
            return $this->errorResponse(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (\Exception $e) {
            // Handle any other unforeseen errors
            return $this->errorResponse(
                'An unexpected error occurred.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
