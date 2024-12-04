<?php

namespace App\Http\Controllers\Api\V1\Teacher;

use App\Domain\Course\Models\Teacher;
use App\Domain\Course\Services\TeacherService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class ToggleTeacherStatusController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(Teacher $teacher): JsonResponse
    {
        $updated = $this->teacherService->toggleTeacherStatus($teacher);

        if ($updated) {
            return $this->successResponse(
                ['is_active' => $teacher->fresh()->is_active],
                'Teacher status updated successfully'
            );
        }

        return $this->errorResponse('Failed to update teacher status');
    }
} 