<?php

namespace App\Http\Controllers\Api\V1\Admin\Course;

use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


final class SearchCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(SearchCourseRequest $request): JsonResponse
    {
        try {
            $results = $this->courseService->searchCourses(
                $request->getQuery(),
                $request->getFilters()
            );

            return $this->successResponse(
                $results->toArray(),
                'Search results retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'An error occurred while searching for courses.',
                500,
                $e->getMessage()
            );
        }
    }
}
