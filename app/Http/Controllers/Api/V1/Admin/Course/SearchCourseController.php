<?php

namespace App\Http\Controllers\Api\V1\Admin\Course;

use App\Domain\Course\Services\CourseService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchCourseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        // TODO: we must make a separated Form Reuqest for SearchCourseRequest in order to follow SoC and Solid.
        // TODO: we must make error handling with try catch in order to catch any exception.
        $request->validate([
            'query' => 'required|string|min:3',
            'filters' => 'nullable|array',
            'filters.level' => 'nullable|string',
            'filters.price_min' => 'nullable|numeric|min:0',
            'filters.price_max' => 'nullable|numeric|gt:filters.price_min',
            'filters.teacher_id' => 'nullable|integer|exists:teachers,id',
            'filters.is_published' => 'nullable|boolean',
        ]);

        $results = $this->courseService->searchCourses(
            $request->input('query'),
            $request->input('filters', [])
        );

        return $this->successResponse(
            $results->toArray(),
            'Search results retrieved successfully'
        );
    }
} 