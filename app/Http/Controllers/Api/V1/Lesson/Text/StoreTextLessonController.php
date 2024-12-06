<?php

namespace App\Http\Controllers\Api\V1\Lesson\Text;

use App\Domain\Course\DTOs\TextLesson\CreateTextLessonDto;
use App\Domain\Course\Services\TextLessonService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;

class StoreTextLessonController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TextLessonService $textLessonService
    ) {}

    public function __invoke(CreateTextLessonDto $dto): JsonResponse
    {
        $textLesson = $this->textLessonService->createTextLesson($dto->toArray());

        return $this->respondCreated([
            'message' => 'Text lesson created successfully',
            'data' => $textLesson
        ]);
    }
} 