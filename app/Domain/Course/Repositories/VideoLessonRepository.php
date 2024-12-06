<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\Interfaces\VideoLessonRepositoryInterface;
use App\Domain\Course\Models\VideoLesson;
use Illuminate\Database\Eloquent\Collection;

class VideoLessonRepository implements VideoLessonRepositoryInterface
{
    public function __construct(
        private readonly VideoLesson $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?VideoLesson
    {
        return $this->model->find($id);
    }

    public function create(array $data): VideoLesson
    {
        return $this->model->create($data);
    }

    public function update(VideoLesson $videoLesson, array $data): bool
    {
        return $videoLesson->update($data);
    }

    public function delete(VideoLesson $videoLesson): bool
    {
        return $videoLesson->delete();
    }

    public function getByDuration(int $minDuration, int $maxDuration): Collection
    {
        return $this->model
            ->whereBetween('duration', [$minDuration, $maxDuration])
            ->get();
    }

    public function getByProvider(string $provider): Collection
    {
        return $this->model
            ->where('provider', $provider)
            ->get();
    }

    public function getWithCaptions(): Collection
    {
        return $this->model
            ->whereNotNull('captions_url')
            ->get();
    }

    public function getWithTranscript(): Collection
    {
        return $this->model
            ->whereNotNull('transcript')
            ->get();
    }
} 