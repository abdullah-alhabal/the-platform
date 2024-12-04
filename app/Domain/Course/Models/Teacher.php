<?php

namespace App\Domain\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'bio',
        'avatar',
        'expertise',
        'qualification',
        'is_active',
    ];

    protected $casts = [
        'expertise' => 'array',
        'qualification' => 'array',
        'is_active' => 'boolean',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function ratingReplies(): HasMany
    {
        return $this->hasMany(RatingReply::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->courses()
            ->withAvg('ratings', 'rating')
            ->get()
            ->avg('ratings_avg_rating') ?? 0.0;
    }

    public function getTotalStudentsAttribute(): int
    {
        return $this->courses()
            ->withCount('enrollments')
            ->get()
            ->sum('enrollments_count');
    }

    public function getTotalCoursesAttribute(): int
    {
        return $this->courses()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
