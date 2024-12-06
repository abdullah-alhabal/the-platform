<?php

namespace App\Domain\Course\Services;

use App\Domain\Course\Interfaces\LiveLessonRepositoryInterface;
use App\Domain\Course\Models\LiveLesson;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class LiveLessonService
{
    private const CACHE_PREFIX = 'live_lesson:';
    private const CACHE_TTL = 3600; // 1 hour

    public function __construct(
        private readonly LiveLessonRepositoryInterface $liveLessonRepository
    ) {}

    public function getAllLiveLessons(): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . 'all',
            self::CACHE_TTL,
            fn() => $this->liveLessonRepository->all()
        );
    }

    public function findLiveLesson(int $id): ?LiveLesson
    {
        /** @var ?LiveLesson */
        return Cache::remember(
            self::CACHE_PREFIX . $id,
            self::CACHE_TTL,
            fn() => $this->liveLessonRepository->findById($id)
        );
    }

    public function createLiveLesson(array $data): LiveLesson
    {
        $liveLesson = $this->liveLessonRepository->create($data);
        $this->clearCache();
        return $liveLesson;
    }

    public function updateLiveLesson(LiveLesson $liveLesson, array $data): bool
    {
        $updated = $this->liveLessonRepository->update($liveLesson, $data);
        if ($updated) {
            $this->clearCache();
        }
        return $updated;
    }

    public function deleteLiveLesson(LiveLesson $liveLesson): bool
    {
        $deleted = $this->liveLessonRepository->delete($liveLesson);
        if ($deleted) {
            $this->clearCache();
        }
        return $deleted;
    }

    public function getUpcomingLessons(): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . 'upcoming',
            300, // 5 minutes
            fn() => $this->liveLessonRepository->getUpcoming()
        );
    }

    public function getPastLessons(): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . 'past',
            self::CACHE_TTL,
            fn() => $this->liveLessonRepository->getPast()
        );
    }

    public function getLessonsByInstructor(int $instructorId): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . "instructor:{$instructorId}",
            self::CACHE_TTL,
            fn() => $this->liveLessonRepository->getByInstructor($instructorId)
        );
    }

    public function getLessonsByPlatform(string $platform): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . "platform:{$platform}",
            self::CACHE_TTL,
            fn() => $this->liveLessonRepository->getByPlatform($platform)
        );
    }

    public function getLessonsWithRecording(): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . 'with_recording',
            self::CACHE_TTL,
            fn() => $this->liveLessonRepository->getWithRecording()
        );
    }

    private function clearCache(): void
    {
        Cache::tags([self::CACHE_PREFIX])->flush();
    }
} 