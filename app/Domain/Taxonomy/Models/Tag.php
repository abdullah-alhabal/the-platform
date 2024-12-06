<?php

namespace App\Domain\Taxonomy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta_keywords' => 'array',
    ];

    public function courses(): MorphToMany
    {
        return $this->morphedByMany('App\Domain\Course\Models\Course', 'taggable');
    }

    public function lessons(): MorphToMany
    {
        return $this->morphedByMany('App\Domain\Course\Models\Lesson', 'taggable');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    public static function findByName(string $name): ?self
    {
        return static::where('name', $name)->first();
    }

    public static function findOrCreateByName(string $name, string $type = 'general'): self
    {
        return static::firstOrCreate(
            ['name' => $name],
            [
                'slug' => str($name)->slug(),
                'type' => $type,
            ]
        );
    }
} 