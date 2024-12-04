<?php

namespace App\Http\Controllers\Api\V1\Teacher;

use App\Domain\Course\Services\TeacherService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TopRatedTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 6);
        $teachers = $this->teacherService->getTopRatedTeachers($limit);

        return $this->successResponse($teachers, 'Top rated teachers retrieved successfully');
    }
} 