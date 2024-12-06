<?php

namespace App\Domain\Course\Repositories;

use App\Domain\Course\Interfaces\TextLessonRepositoryInterface;
use App\Domain\Course\Models\TextLesson;
use Illuminate\Database\Eloquent\Collection;

class TextLessonRepository implements TextLessonRepositoryInterface
{
    public function __construct(
        private readonly TextLesson $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?TextLesson
    {
        return $this->model->find($id);
    }

    public function create(array $data): TextLesson
    {
        return $this->model->create($data);
    }

    public function update(TextLesson $textLesson, array $data): bool
    {
        return $textLesson->update($data);
    }

    public function delete(TextLesson $textLesson): bool
    {
        return $textLesson->delete();
    }

    public function getByReadingTime(int $minMinutes, int $maxMinutes): Collection
    {
        return $this->model
            ->whereBetween('reading_time', [$minMinutes, $maxMinutes])
            ->get();
    }

    public function getWithAttachments(): Collection
    {
        return $this->model
            ->has('attachments')
            ->get();
    }

    public function searchContent(string $query): Collection
    {
        return $this->model
            ->where('content', 'like', "%{$query}%")
            ->orWhere('summary', 'like', "%{$query}%")
            ->get();
    }

    public function getByFormat(string $format): Collection
    {
        return $this->model
            ->where('format', $format)
            ->get();
    }
} 