<?php

namespace App\Domain\Course\Events\Course;

use App\Domain\Course\Models\Course;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Course $course,
        public readonly array $changes
    ) {}
} 