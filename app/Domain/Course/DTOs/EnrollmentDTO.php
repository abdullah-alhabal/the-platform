<?php

namespace App\Domain\Course\DTOs;

use App\Domain\Course\Models\CourseEnrollment;

class EnrollmentDTO
{
    public function __construct(
        public readonly CourseEnrollment $enrollment,
        public readonly ?array $stats = null
    ) {}

    public function toArray(): array
    {
        $data = [
            'id' => $this->enrollment->id,
            'course' => [
                'id' => $this->enrollment->course->id,
                'title' => $this->enrollment->course->title,
                'thumbnail' => $this->enrollment->course->thumbnail,
            ],
            'student' => [
                'id' => $this->enrollment->student->id,
                'name' => $this->enrollment->student->name,
            ],
            'paid_amount' => $this->enrollment->paid_amount,
            'payment_method' => $this->enrollment->payment_method,
            'payment_status' => $this->enrollment->payment_status,
            'enrolled_at' => $this->enrollment->enrolled_at->toISOString(),
            'expires_at' => $this->enrollment->expires_at?->toISOString(),
            'status' => $this->enrollment->status,
            'progress_percentage' => $this->enrollment->progress_percentage,
            'last_accessed_at' => $this->enrollment->last_accessed_at?->toISOString(),
            'is_expired' => $this->enrollment->isExpired(),
            'is_active' => $this->enrollment->isActive(),
        ];

        if ($this->stats) {
            $data['stats'] = [
                'completed_lessons' => $this->stats['completed_lessons'],
                'total_lessons' => $this->stats['total_lessons'],
                'study_duration_days' => $this->stats['study_duration_days'],
                'last_accessed' => $this->stats['last_accessed'],
                'days_until_expiry' => $this->stats['days_until_expiry'],
                'completion_rate' => $this->stats['completion_rate'],
            ];
        }

        return $data;
    }
} 