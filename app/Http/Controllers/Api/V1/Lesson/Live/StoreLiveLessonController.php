<?php

namespace App\Http\Controllers\Api\V1\Lesson\Live;

use App\Domain\Course\DTOs\LiveLesson\CreateLiveLessonDto;
use App\Domain\Course\Services\LiveLessonService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class StoreLiveLessonController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LiveLessonService $liveLessonService
    ) {}

    public function __invoke(CreateLiveLessonDto $dto): JsonResponse
    {
        $liveLesson = $this->liveLessonService->createLiveLesson($dto->toArray());

        return $this->respondCreated([
            'message' => 'Live lesson created successfully',
            'data' => $liveLesson
        ]);
    }
} 