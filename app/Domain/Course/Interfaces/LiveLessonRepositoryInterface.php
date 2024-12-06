<?php

namespace App\Domain\Course\Interfaces;

use App\Domain\Course\Models\LiveLesson;
use Illuminate\Database\Eloquent\Collection;

interface LiveLessonRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): ?LiveLesson;
    public function create(array $data): LiveLesson;
    public function update(LiveLesson $liveLesson, array $data): bool;
    public function delete(LiveLesson $liveLesson): bool;
    public function getUpcoming(): Collection;
    public function getPast(): Collection;
    public function getByInstructor(int $instructorId): Collection;
    public function getByPlatform(string $platform): Collection;
    public function getWithRecording(): Collection;
} 