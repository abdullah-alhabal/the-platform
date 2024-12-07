<?php

namespace App\Domain\Course\DTOs\Course;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class CourseDetailsDto
{
    public function __construct(
        public readonly CourseStatisticsDto $statistics,
        public readonly Collection $sections, // A collection of SectionDto
        public readonly LengthAwarePaginator $ratings, // A paginator of RatingDto
        public readonly CourseBasicDto $course, // A DTO for the course's basic data
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            statistics: CourseStatisticsDto::fromArray($data['statistics']),
            sections: collect($data['sections'])->map(fn($section) => SectionDto::fromArray($section)),
            ratings: $data['ratings'], // Assuming the paginator already wraps RatingDto
            course: CourseBasicDto::fromArray($data['course']),
        );
    }

    public function toArray(): array
    {
        return [
            'statistics' => $this->statistics->toArray(),
            'sections' => $this->sections->map->toArray()->all(),
            'ratings' => $this->ratings->items(),
            'course' => $this->course->toArray(),
        ];
    }
}
