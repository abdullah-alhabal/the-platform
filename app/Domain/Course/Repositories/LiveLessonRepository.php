<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\Interfaces\LiveLessonRepositoryInterface;
use App\Domain\Course\Models\LiveLesson;
use Illuminate\Database\Eloquent\Collection;

class LiveLessonRepository implements LiveLessonRepositoryInterface
{
    public function __construct(
        private readonly LiveLesson $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?LiveLesson
    {
        return $this->model->find($id);
    }

    public function create(array $data): LiveLesson
    {
        return $this->model->create($data);
    }

    public function update(LiveLesson $liveLesson, array $data): bool
    {
        return $liveLesson->update($data);
    }

    public function delete(LiveLesson $liveLesson): bool
    {
        return $liveLesson->delete();
    }

    public function getUpcoming(): Collection
    {
        return $this->model
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->get();
    }

    public function getPast(): Collection
    {
        return $this->model
            ->where('end_time', '<', now())
            ->orderByDesc('end_time')
            ->get();
    }

    public function getByInstructor(int $instructorId): Collection
    {
        return $this->model
            ->where('instructor_id', $instructorId)
            ->orderBy('start_time')
            ->get();
    }

    public function getByPlatform(string $platform): Collection
    {
        return $this->model
            ->where('platform', $platform)
            ->get();
    }

    public function getWithRecording(): Collection
    {
        return $this->model
            ->whereNotNull('recording_url')
            ->get();
    }
} 