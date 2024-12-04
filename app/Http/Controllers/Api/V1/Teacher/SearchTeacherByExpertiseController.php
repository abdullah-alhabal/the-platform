<?php

namespace App\Http\Controllers\Api\V1\Teacher;

use App\Domain\Course\Services\TeacherService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchTeacherByExpertiseController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(['expertise' => 'required|string']);
        $teachers = $this->teacherService->findTeachersByExpertise($request->expertise);

        return $this->successResponse($teachers, 'Teachers found successfully');
    }
} 