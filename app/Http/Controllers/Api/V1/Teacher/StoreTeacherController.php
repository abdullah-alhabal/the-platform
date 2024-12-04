<?php

namespace App\Http\Controllers\Api\V1\Teacher;

use App\Domain\Course\DTOs\Teacher\CreateTeacherDto;
use App\Domain\Course\Events\Teacher\TeacherCreated;
use App\Domain\Course\Services\TeacherService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Teacher\CreateTeacherRequest;
use Illuminate\Http\JsonResponse;

class StoreTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(CreateTeacherRequest $request): JsonResponse
    {
        $dto = CreateTeacherDto::fromArray($request->validated());
        $teacher = $this->teacherService->createTeacher($dto);

        TeacherCreated::dispatch($teacher);

        return $this->createdResponse(
            $teacher->toArray(),
            'Teacher created successfully'
        );
    }
} 