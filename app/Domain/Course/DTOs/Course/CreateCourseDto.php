<?php

namespace App\Domain\Course\DTOs\Course;

use App\Domain\Course\Enums\CourseLevel;

class CreateCourseDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly string $description,
        public readonly CourseLevel $level,
        public readonly int $teacher_id,
        public readonly float $price,
        public readonly ?string $thumbnail = null,
        public readonly ?string $preview_video = null,
        public readonly ?array $requirements = [],
        public readonly ?array $learning_outcomes = [],
        public readonly bool $is_published = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            slug: $data['slug'],
            description: $data['description'],
            level: CourseLevel::from($data['level']),
            teacher_id: $data['teacher_id'],
            price: $data['price'],
            thumbnail: $data['thumbnail'] ?? null,
            preview_video: $data['preview_video'] ?? null,
            requirements: $data['requirements'] ?? [],
            learning_outcomes: $data['learning_outcomes'] ?? [],
            is_published: $data['is_published'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'level' => $this->level->value,
            'teacher_id' => $this->teacher_id,
            'price' => $this->price,
            'thumbnail' => $this->thumbnail,
            'preview_video' => $this->preview_video,
            'requirements' => $this->requirements,
            'learning_outcomes' => $this->learning_outcomes,
            'is_published' => $this->is_published,
        ];
    }
} 