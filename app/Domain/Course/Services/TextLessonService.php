<?php

namespace App\Domain\Course\Services;

use App\Domain\Course\Interfaces\TextLessonRepositoryInterface;
use App\Domain\Course\Models\TextLesson;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TextLessonService
{
    private const CACHE_PREFIX = 'text_lesson:';
    private const CACHE_TTL = 3600; // 1 hour

    public function __construct(
        private readonly TextLessonRepositoryInterface $textLessonRepository
    ) {}

    public function getAllTextLessons(): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . 'all',
            self::CACHE_TTL,
            fn() => $this->textLessonRepository->all()
        );
    }

    public function findTextLesson(int $id): ?TextLesson
    {
        /** @var ?TextLesson */
        return Cache::remember(
            self::CACHE_PREFIX . $id,
            self::CACHE_TTL,
            fn() => $this->textLessonRepository->findById($id)
        );
    }

    public function createTextLesson(array $data): TextLesson
    {
        $textLesson = $this->textLessonRepository->create($data);
        $this->clearCache();
        return $textLesson;
    }

    public function updateTextLesson(TextLesson $textLesson, array $data): bool
    {
        $updated = $this->textLessonRepository->update($textLesson, $data);
        if ($updated) {
            $this->clearCache();
        }
        return $updated;
    }

    public function deleteTextLesson(TextLesson $textLesson): bool
    {
        $deleted = $this->textLessonRepository->delete($textLesson);
        if ($deleted) {
            $this->clearCache();
        }
        return $deleted;
    }

    public function getLessonsByReadingTime(int $minMinutes, int $maxMinutes): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . "reading_time:{$minMinutes}-{$maxMinutes}",
            self::CACHE_TTL,
            fn() => $this->textLessonRepository->getByReadingTime($minMinutes, $maxMinutes)
        );
    }

    public function getLessonsWithAttachments(): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . 'with_attachments',
            self::CACHE_TTL,
            fn() => $this->textLessonRepository->getWithAttachments()
        );
    }

    public function searchLessonContent(string $query): Collection
    {
        // Don't cache search results
        return $this->textLessonRepository->searchContent($query);
    }

    public function getLessonsByFormat(string $format): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . "format:{$format}",
            self::CACHE_TTL,
            fn() => $this->textLessonRepository->getByFormat($format)
        );
    }

    private function clearCache(): void
    {
        Cache::tags([self::CACHE_PREFIX])->flush();
    }
} 