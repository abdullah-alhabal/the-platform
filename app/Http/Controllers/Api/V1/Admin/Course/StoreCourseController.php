<?php

namespace App\Http\Controllers\Api\V1\Admin\Course;

use App\Domain\Course\Events\Course\CourseCreated;
use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Course\CreateCourseRequest;
use Illuminate\Http\JsonResponse;

class StoreCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(CreateCourseRequest $request): JsonResponse
    {
        // TODO: error handling
        $course = $this->courseService->createCourse($request->toDto());

        CourseCreated::dispatch($course);

        return $this->createdResponse(
            $course->toArray(),
            'Course created successfully'
        );
    }
}
