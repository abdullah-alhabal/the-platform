<?php

namespace App\Domain\Course\DTOs\TextLesson;

use Spatie\LaravelData\Data;

class CreateTextLessonDto extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly string $format,
        public readonly ?string $summary = null,
        public readonly ?int $reading_time = null,
        public readonly ?array $attachments = null,
        public readonly bool $requires_subscription = true,
    ) {}

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'format' => ['required', 'string', 'in:markdown,html,plain'],
            'summary' => ['nullable', 'string', 'max:500'],
            'reading_time' => ['nullable', 'integer', 'min:1'],
            'attachments' => ['nullable', 'array'],
            'attachments.*.title' => ['required_with:attachments', 'string'],
            'attachments.*.url' => ['required_with:attachments', 'url'],
            'attachments.*.type' => ['required_with:attachments', 'string', 'in:pdf,doc,image,other'],
            'requires_subscription' => ['boolean'],
        ];
    }
} 