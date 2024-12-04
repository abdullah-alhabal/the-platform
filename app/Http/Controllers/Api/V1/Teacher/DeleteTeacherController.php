<?php

namespace App\Http\Controllers\Api\V1\Teacher;

use App\Domain\Course\Events\Teacher\TeacherDeleted;
use App\Domain\Course\Models\Teacher;
use App\Domain\Course\Services\TeacherService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class DeleteTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(Teacher $teacher): JsonResponse
    {
        $deleted = $this->teacherService->deleteTeacher($teacher);

        if ($deleted) {
            TeacherDeleted::dispatch($teacher);
            return $this->noContentResponse();
        }

        return $this->errorResponse('Failed to delete teacher');
    }
} 