<?php

namespace App\Domain\Course\DTOs\VideoLesson;

use Spatie\LaravelData\Data;

class CreateVideoLessonDto extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $video_url,
        public readonly string $provider,
        public readonly int $duration,
        public readonly ?string $thumbnail_url = null,
        public readonly ?string $captions_url = null,
        public readonly ?string $transcript = null,
        public readonly ?array $chapters = null,
        public readonly bool $is_downloadable = false,
        public readonly bool $requires_subscription = true,
    ) {}

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'video_url' => ['required', 'url'],
            'provider' => ['required', 'string', 'in:youtube,vimeo,wistia,custom'],
            'duration' => ['required', 'integer', 'min:1'],
            'thumbnail_url' => ['nullable', 'url'],
            'captions_url' => ['nullable', 'url'],
            'transcript' => ['nullable', 'string'],
            'chapters' => ['nullable', 'array'],
            'chapters.*.title' => ['required_with:chapters', 'string'],
            'chapters.*.time' => ['required_with:chapters', 'integer', 'min:0'],
            'is_downloadable' => ['boolean'],
            'requires_subscription' => ['boolean'],
        ];
    }
} 