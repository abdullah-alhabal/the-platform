<?php

namespace App\Http\Controllers\Api\V1\Course;

use App\Domain\Course\Events\Course\CourseUpdated;
use App\Domain\Course\Models\Course;
use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Course\UpdateCourseRequest;
use Illuminate\Http\JsonResponse;

class UpdateCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(UpdateCourseRequest $request, Course $course): JsonResponse
    {
        $updated = $this->courseService->updateCourse($course, $request->toDto());

        if ($updated) {
            CourseUpdated::dispatch($course, $request->validated());
            return $this->successResponse(null, 'Course updated successfully');
        }

        return $this->errorResponse('Failed to update course');
    }
} 