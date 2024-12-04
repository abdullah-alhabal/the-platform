<?php

namespace App\Http\Controllers\Api\V1\Course;

use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $filters = $request->only(['level', 'teacher_id', 'is_published', 'price_min', 'price_max']);
        $courses = $this->courseService->getAllCourses($filters);

        return $this->successResponse(
            $courses->toArray(),
            'Courses retrieved successfully'
        );
    }
} 