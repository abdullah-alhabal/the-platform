<?php

namespace App\Http\Controllers\Api\V1\Admin\Course;

use App\Domain\Course\Events\Course\CourseUnpublished;
use App\Domain\Course\Models\Course;
use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class UnpublishCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(Course $course): JsonResponse
    {
        // TODO: error handling
        $this->authorize('publish', $course);

        $unpublished = $this->courseService->unpublishCourse($course);

        if ($unpublished) {
            CourseUnpublished::dispatch($course);
            return $this->successResponse(
                ['is_published' => false],
                'Course unpublished successfully'
            );
        }

        return $this->errorResponse('Failed to unpublish course');
    }
} 