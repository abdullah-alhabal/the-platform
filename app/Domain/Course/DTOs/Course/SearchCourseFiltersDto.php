<?php

namespace App\Domain\Course\DTOs\Course;

class SearchCourseFiltersDto
{
    public function __construct(
        public ?string $level = null,
        public ?int $teacherId = null,
        public ?bool $isPublished = null,
        public ?float $priceMin = null,
        public ?float $priceMax = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            level: $data['level'] ?? null,
            teacherId: $data['teacher_id'] ?? null,
            isPublished: isset($data['is_published']) ? (bool)$data['is_published'] : null,
            priceMin: isset($data['price_min']) ? (float)$data['price_min'] : null,
            priceMax: isset($data['price_max']) ? (float)$data['price_max'] : null
        );
    }
}
