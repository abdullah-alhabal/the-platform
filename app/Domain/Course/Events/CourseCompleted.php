<?php

namespace App\Domain\Course\Events;

use App\Domain\Course\Models\CourseEnrollment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseCompleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly CourseEnrollment $enrollment
    ) {}
} 