<?php

namespace App\Domain\Course\Models;

use App\Domain\Course\Interfaces\LessonableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class LiveLesson extends Model implements LessonableInterface
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'meeting_url',
        'meeting_password',
        'platform',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function lesson(): MorphOne
    {
        return $this->morphOne(Lesson::class, 'lessonable');
    }

    public function getDuration(): int
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }

    public function getType(): string
    {
        return 'live';
    }

    public function getStatusAttribute(): string
    {
        $now = Carbon::now();

        if ($now->lt($this->start_time)) {
            return 'upcoming';
        }

        if ($now->between($this->start_time, $this->end_time)) {
            return 'live';
        }

        return 'ended';
    }

    public function isLive(): bool
    {
        return $this->status === 'live';
    }

    public function hasEnded(): bool
    {
        return $this->status === 'ended';
    }

    public function getTimeUntilStartAttribute(): string
    {
        if ($this->hasEnded()) {
            return 'Ended';
        }

        if ($this->isLive()) {
            return 'Live now';
        }

        return $this->start_time->diffForHumans();
    }
}
