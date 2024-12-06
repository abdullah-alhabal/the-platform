<?php

namespace App\Http\Controllers\Api\V1\Admin\Course;

use App\Domain\Course\Events\Course\CoursePublished;
use App\Domain\Course\Models\Course;
use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class PublishCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(Course $course): JsonResponse
    {
        // TODO: error handling
        $this->authorize('publish', $course);

        $published = $this->courseService->publishCourse($course);

        if ($published) {
            CoursePublished::dispatch($course);
            return $this->successResponse(
                ['is_published' => true],
                'Course published successfully'
            );
        }

        return $this->errorResponse('Failed to publish course');
    }
} 