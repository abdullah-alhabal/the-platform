<?php

namespace App\Domain\Course\DTOs\LiveLesson;

use Spatie\LaravelData\Data;

class CreateLiveLessonDto extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $platform,
        public readonly string $meeting_url,
        public readonly \DateTime $start_time,
        public readonly \DateTime $end_time,
        public readonly int $instructor_id,
        public readonly int $max_attendees,
        public readonly ?string $recording_url = null,
        public readonly ?array $materials = null,
        public readonly bool $requires_subscription = true,
    ) {}

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'platform' => ['required', 'string', 'in:zoom,google_meet,microsoft_teams,custom'],
            'meeting_url' => ['required', 'url'],
            'start_time' => ['required', 'date', 'after:now'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'instructor_id' => ['required', 'integer', 'exists:teachers,id'],
            'max_attendees' => ['required', 'integer', 'min:1'],
            'recording_url' => ['nullable', 'url'],
            'materials' => ['nullable', 'array'],
            'materials.*.title' => ['required_with:materials', 'string'],
            'materials.*.url' => ['required_with:materials', 'url'],
            'requires_subscription' => ['boolean'],
        ];
    }
} 