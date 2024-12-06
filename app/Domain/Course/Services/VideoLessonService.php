<?php

namespace App\Domain\Course\Services;

use App\Domain\Course\Interfaces\VideoLessonRepositoryInterface;
use App\Domain\Course\Models\VideoLesson;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class VideoLessonService
{
    private const CACHE_PREFIX = 'video_lesson:';
    private const CACHE_TTL = 3600; // 1 hour

    public function __construct(
        private readonly VideoLessonRepositoryInterface $videoLessonRepository
    ) {}

    public function getAllVideoLessons(): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . 'all',
            self::CACHE_TTL,
            fn() => $this->videoLessonRepository->all()
        );
    }

    public function findVideoLesson(int $id): ?VideoLesson
    {
        /** @var ?VideoLesson */
        return Cache::remember(
            self::CACHE_PREFIX . $id,
            self::CACHE_TTL,
            fn() => $this->videoLessonRepository->findById($id)
        );
    }

    public function createVideoLesson(array $data): VideoLesson
    {
        $videoLesson = $this->videoLessonRepository->create($data);
        $this->clearCache();
        return $videoLesson;
    }

    public function updateVideoLesson(VideoLesson $videoLesson, array $data): bool
    {
        $updated = $this->videoLessonRepository->update($videoLesson, $data);
        if ($updated) {
            $this->clearCache();
        }
        return $updated;
    }

    public function deleteVideoLesson(VideoLesson $videoLesson): bool
    {
        $deleted = $this->videoLessonRepository->delete($videoLesson);
        if ($deleted) {
            $this->clearCache();
        }
        return $deleted;
    }

    public function getVideosByDuration(int $minDuration, int $maxDuration): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . "duration:{$minDuration}-{$maxDuration}",
            self::CACHE_TTL,
            fn() => $this->videoLessonRepository->getByDuration($minDuration, $maxDuration)
        );
    }

    public function getVideosByProvider(string $provider): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . "provider:{$provider}",
            self::CACHE_TTL,
            fn() => $this->videoLessonRepository->getByProvider($provider)
        );
    }

    public function getVideosWithCaptions(): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . 'with_captions',
            self::CACHE_TTL,
            fn() => $this->videoLessonRepository->getWithCaptions()
        );
    }

    public function getVideosWithTranscript(): Collection
    {
        /** @var Collection */
        return Cache::remember(
            self::CACHE_PREFIX . 'with_transcript',
            self::CACHE_TTL,
            fn() => $this->videoLessonRepository->getWithTranscript()
        );
    }

    private function clearCache(): void
    {
        Cache::tags([self::CACHE_PREFIX])->flush();
    }
} 