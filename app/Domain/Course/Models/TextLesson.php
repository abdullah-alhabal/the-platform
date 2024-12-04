<?php

namespace App\Domain\Course\Models;

use App\Domain\Course\Interfaces\LessonableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TextLesson extends Model implements LessonableInterface
{
    use HasFactory;

    protected $fillable = [
        'content',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function lesson(): MorphOne
    {
        return $this->morphOne(Lesson::class, 'lessonable');
    }

    public function getDuration(): int
    {
        // Estimate reading time based on word count (average reading speed: 200 words per minute)
        $wordCount = str_word_count(strip_tags($this->content));
        return (int) ceil($wordCount / 200);
    }

    public function getType(): string
    {
        return 'text';
    }

    public function getFormattedContentAttribute(): string
    {
        // Here you could implement any content formatting logic
        // For example, converting markdown to HTML
        return $this->content;
    }
}
