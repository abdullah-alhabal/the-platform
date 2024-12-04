<?php

namespace App\Domain\Course\DTOs\Course;

use App\Domain\Course\Enums\CourseLevel;

class UpdateCourseDto
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $slug = null,
        public readonly ?string $description = null,
        public readonly ?CourseLevel $level = null,
        public readonly ?float $price = null,
        public readonly ?string $thumbnail = null,
        public readonly ?string $preview_video = null,
        public readonly ?array $requirements = null,
        public readonly ?array $learning_outcomes = null,
        public readonly ?bool $is_published = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? null,
            slug: $data['slug'] ?? null,
            description: $data['description'] ?? null,
            level: isset($data['level']) ? CourseLevel::from($data['level']) : null,
            price: $data['price'] ?? null,
            thumbnail: $data['thumbnail'] ?? null,
            preview_video: $data['preview_video'] ?? null,
            requirements: $data['requirements'] ?? null,
            learning_outcomes: $data['learning_outcomes'] ?? null,
            is_published: $data['is_published'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'level' => $this->level?->value,
            'price' => $this->price,
            'thumbnail' => $this->thumbnail,
            'preview_video' => $this->preview_video,
            'requirements' => $this->requirements,
            'learning_outcomes' => $this->learning_outcomes,
            'is_published' => $this->is_published,
        ], fn($value) => !is_null($value));
    }
} 