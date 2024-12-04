<?php

namespace App\Http\Controllers\Api\V1\Teacher;

use App\Domain\Course\Models\Teacher;
use App\Domain\Course\Services\TeacherService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class ShowTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(Teacher $teacher): JsonResponse
    {
        $teacherDto = $this->teacherService->getTeacherDetails($teacher);
        return $this->successResponse($teacherDto->toArray());
    }
} 