<?php

namespace App\Domain\Course\Enums;

enum LessonType: string
{
    case VIDEO = 'video';
    case TEXT = 'text';
    case LIVE = 'live';
    case QUIZ = 'quiz';

    public function label(): string
    {
        return match($this) {
            self::VIDEO => 'Video Lesson',
            self::TEXT => 'Text Lesson',
            self::LIVE => 'Live Session',
            self::QUIZ => 'Quiz',
        };
    }

    public function morphClass(): string
    {
        return match($this) {
            self::VIDEO => 'video_lessons',
            self::TEXT => 'text_lessons',
            self::LIVE => 'live_lessons',
            self::QUIZ => 'quizzes',
        };
    }
} 