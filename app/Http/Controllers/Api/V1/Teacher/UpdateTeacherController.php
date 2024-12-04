<?php

namespace App\Http\Controllers\Api\V1\Teacher;

use App\Domain\Course\DTOs\Teacher\UpdateTeacherDto;
use App\Domain\Course\Events\Teacher\TeacherUpdated;
use App\Domain\Course\Models\Teacher;
use App\Domain\Course\Services\TeacherService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use Illuminate\Http\JsonResponse;

class UpdateTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(UpdateTeacherRequest $request, Teacher $teacher): JsonResponse
    {
        $dto = UpdateTeacherDto::fromArray($request->validated());
        $updated = $this->teacherService->updateTeacher($teacher, $dto);

        if ($updated) {
            TeacherUpdated::dispatch($teacher, $dto->toArray());
            return $this->successResponse(null, 'Teacher updated successfully');
        }

        return $this->errorResponse('Failed to update teacher');
    }
} 