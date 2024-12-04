<?php

namespace App\Domain\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RatingReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_rating_id',
        'teacher_id',
        'reply',
    ];

    public function rating(): BelongsTo
    {
        return $this->belongsTo(CourseRating::class, 'course_rating_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function scopeByTeacher($query, int $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
} 