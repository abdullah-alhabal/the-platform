<?php

namespace App\Domain\Course\Models;

use App\Domain\Course\Enums\CourseLevel;
use App\Domain\Identity\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'title',
        'slug',
        'description',
        'requirements',
        'objectives',
        'price',
        'discount_price',
        'level',
        'language',
        'duration_hours',
        'thumbnail',
        'preview_video',
        'is_featured',
        'is_published',
        'published_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'updates_count',
    ];

    public function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'level' => CourseLevel::class,
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'requirements' => 'array',
            'objectives' => 'array',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(CourseSection::class)->orderBy('order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(CourseRating::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->ratings()->avg('rating') ?? 0.0;
    }

    public function getTotalStudentsAttribute(): int
    {
        return $this->enrollments()->count();
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if (!$this->discount_price) {
            return null;
        }

        return (int)(100 - ($this->discount_price * 100 / $this->price));
    }

    public function getCurrentPriceAttribute(): float
    {
        return $this->discount_price ?? $this->price;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
