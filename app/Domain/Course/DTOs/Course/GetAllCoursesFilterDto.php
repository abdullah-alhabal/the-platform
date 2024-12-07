<?php

namespace App\Domain\Course\DTOs\Course;


class GetAllCoursesFilterDto
{
    public function __construct(
        public readonly ?string $level = null,
        public readonly ?int $teacherId = null,
        public readonly ?bool $isPublished = null,
        public readonly ?float $priceMin = null,
        public readonly ?float $priceMax = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            level: $data['level'] ?? null,
            teacherId: isset($data['teacher_id']) ? (int) $data['teacher_id'] : null,
            isPublished: isset($data['is_published']) ? filter_var($data['is_published'], FILTER_VALIDATE_BOOLEAN) : null,
            priceMin: isset($data['price_min']) ? (float) $data['price_min'] : null,
            priceMax: isset($data['price_max']) ? (float) $data['price_max'] : null,
        );
    }
}
