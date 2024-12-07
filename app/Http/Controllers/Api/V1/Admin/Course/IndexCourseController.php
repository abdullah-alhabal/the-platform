<?php

namespace App\Http\Controllers\Api\V1\Admin\Course;

use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Admin\Course\GetAllCoursesRequest;
use Illuminate\Http\JsonResponse;

class IndexCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(GetAllCoursesRequest $request): JsonResponse
    {
        $filtersDto = $request->toDto();
        $courses = $this->courseService->getAllCourses($filtersDto);

        return $this->successResponse(
            $courses->toArray(),
            'Courses retrieved successfully'
        );
    }
}
