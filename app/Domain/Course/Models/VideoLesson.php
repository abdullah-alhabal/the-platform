<?php

namespace App\Domain\Course\Models;

use App\Domain\Course\Interfaces\LessonableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoLesson extends Model implements LessonableInterface
{
    use HasFactory;

    protected $fillable = [
        'video_url',
        'video_provider',
        'transcript',
    ];

    public function lesson(): MorphOne
    {
        return $this->morphOne(Lesson::class, 'lessonable');
    }

    public function getDuration(): int
    {
        // In a real application, you would fetch this from the video provider's API
        return $this->lesson->duration_minutes;
    }

    public function getType(): string
    {
        return 'video';
    }

    public function getEmbedUrl(): string
    {
        // Example implementation for YouTube
        if ($this->video_provider === 'youtube') {
            $videoId = $this->getYoutubeVideoId();
            return "https://www.youtube.com/embed/{$videoId}";
        }

        return $this->video_url;
    }

    protected function getYoutubeVideoId(): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $this->video_url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
