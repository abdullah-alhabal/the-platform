<?php

namespace App\Domain\Course\Interfaces;

use App\Domain\Course\Models\TextLesson;
use Illuminate\Database\Eloquent\Collection;

interface TextLessonRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): ?TextLesson;
    public function create(array $data): TextLesson;
    public function update(TextLesson $textLesson, array $data): bool;
    public function delete(TextLesson $textLesson): bool;
    public function getByReadingTime(int $minMinutes, int $maxMinutes): Collection;
    public function getWithAttachments(): Collection;
    public function searchContent(string $query): Collection;
    public function getByFormat(string $format): Collection;
} 