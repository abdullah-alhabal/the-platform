<?php

namespace App\Domain\Course\Events\Teacher;

use App\Domain\Course\Models\Teacher;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeacherDeleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Teacher $teacher
    ) {}
} 