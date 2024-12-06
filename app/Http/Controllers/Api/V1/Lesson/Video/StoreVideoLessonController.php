<?php

namespace App\Http\Controllers\Api\V1\Lesson\Video;

use App\Domain\Course\DTOs\VideoLesson\CreateVideoLessonDto;
use App\Domain\Course\Services\VideoLessonService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class StoreVideoLessonController extends BaseApiV1Controller
{
    public function __construct(
        private readonly VideoLessonService $videoLessonService
    ) {}

    public function __invoke(CreateVideoLessonDto $dto): JsonResponse
    {
        $videoLesson = $this->videoLessonService->createVideoLesson($dto->toArray());

        return $this->respondCreated([
            'message' => 'Video lesson created successfully',
            'data' => $videoLesson
        ]);
    }
} 