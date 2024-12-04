<?php

namespace App\Http\Controllers\Api\V1\Teacher;

use App\Domain\Course\Services\TeacherService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'expertise', 'is_active', 'min_rating']);
        $teachers = $this->teacherService->getAllTeachers($filters);

        return $this->paginatedResponse($teachers, 'Teachers retrieved successfully');
    }
} 