<?php

namespace App\Domain\Course\DTOs\Course;

final class CourseStatisticsDto
{
    public function __construct(
        public readonly int $totalStudents,
        public readonly int $totalLessons,
        public readonly int $totalDuration,
        public readonly float $averageRating,
        public readonly int $totalRatings
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            totalStudents: $data['total_students'],
            totalLessons: $data['total_lessons'],
            totalDuration: $data['total_duration'],
            averageRating: $data['average_rating'],
            totalRatings: $data['total_ratings']
        );
    }

    public function toArray(): array
    {
        return [
            'totalStudents' => $this->totalStudents,
            'totalLessons' => $this->totalLessons,
            'totalDuration' => $this->totalDuration,
            'averageRating' => $this->averageRating,
            'totalRatings' => $this->totalRatings,
        ];
    }
}
