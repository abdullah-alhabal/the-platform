<?php

namespace App\Domain\Course\DTOs;

use App\Domain\Course\Models\Teacher;

class TeacherDTO
{
    public function __construct(
        public readonly Teacher $teacher,
        public readonly ?array $stats = null
    ) {}

    public function toArray(): array
    {
        $data = [
            'id' => $this->teacher->id,
            'name' => $this->teacher->name,
            'email' => $this->teacher->email,
            'phone' => $this->teacher->phone,
            'bio' => $this->teacher->bio,
            'avatar' => $this->teacher->avatar,
            'expertise' => $this->teacher->expertise,
            'qualification' => $this->teacher->qualification,
            'is_active' => $this->teacher->is_active,
            'courses_count' => $this->teacher->total_courses,
            'students_count' => $this->teacher->total_students,
            'average_rating' => $this->teacher->average_rating,
        ];

        if ($this->stats) {
            $data['stats'] = [
                'total_courses' => $this->stats['total_courses'],
                'total_students' => $this->stats['total_students'],
                'average_rating' => $this->stats['average_rating'],
                'total_reviews' => $this->stats['total_reviews'],
                'revenue' => $this->stats['revenue'],
            ];
        }

        return $data;
    }
} 