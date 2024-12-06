<?php

namespace App\Domain\Course\Interfaces;

use App\Domain\Course\Models\VideoLesson;
use Illuminate\Database\Eloquent\Collection;

interface VideoLessonRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): ?VideoLesson;
    public function create(array $data): VideoLesson;
    public function update(VideoLesson $videoLesson, array $data): bool;
    public function delete(VideoLesson $videoLesson): bool;
    public function getByDuration(int $minDuration, int $maxDuration): Collection;
    public function getByProvider(string $provider): Collection;
    public function getWithCaptions(): Collection;
    public function getWithTranscript(): Collection;
} 