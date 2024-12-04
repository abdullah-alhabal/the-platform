<?php

namespace App\Domain\Course\DTOs;

use App\Domain\Course\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseDTO
{
    public function __construct(
        public readonly Course $course,
        public readonly ?Collection $relatedCourses = null,
        public readonly bool $includeRelated = true
    ) {}

    public function toArray(): array
    {
        $data = [
            'id' => $this->course->id,
            'title' => $this->course->title,
            'slug' => $this->course->slug,
            'description' => $this->course->description,
            'requirements' => $this->course->requirements,
            'objectives' => $this->course->objectives,
            'price' => $this->course->price,
            'discount_price' => $this->course->discount_price,
            'current_price' => $this->course->current_price,
            'discount_percentage' => $this->course->discount_percentage,
            'level' => [
                'value' => $this->course->level->value,
                'label' => $this->course->level->label(),
            ],
            'language' => $this->course->language,
            'duration_hours' => $this->course->duration_hours,
            'thumbnail' => $this->course->thumbnail,
            'preview_video' => $this->course->preview_video,
            'is_featured' => $this->course->is_featured,
            'is_published' => $this->course->is_published,
            'published_at' => $this->course->published_at?->toISOString(),
            'average_rating' => $this->course->average_rating,
            'total_students' => $this->course->total_students,
            'teacher' => [
                'id' => $this->course->teacher->id,
                'name' => $this->course->teacher->name,
                'avatar' => $this->course->teacher->avatar,
                'bio' => $this->course->teacher->bio,
            ],
            'sections' => $this->course->sections->map(function ($section) {
                return [
                    'id' => $section->id,
                    'title' => $section->title,
                    'description' => $section->description,
                    'order' => $section->order,
                    'duration' => $section->duration,
                    'lessons_count' => $section->lessons->count(),
                    'completion_percentage' => $section->completion_percentage,
                ];
            }),
        ];

        if ($this->includeRelated && $this->relatedCourses) {
            $data['related_courses'] = $this->relatedCourses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'thumbnail' => $course->thumbnail,
                    'price' => $course->current_price,
                    'average_rating' => $course->average_rating,
                ];
            });
        }

        return $data;
    }
} 