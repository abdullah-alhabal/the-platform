<?php

namespace App\Domain\Taxonomy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Term extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'taxonomy_id',
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'meta_keywords' => 'array',
    ];

    public function taxonomy(): BelongsTo
    {
        return $this->belongsTo(Taxonomy::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Term::class, 'parent_id');
    }

    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    public function ancestors(): Collection
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors->reverse();
    }

    public function courses(): MorphToMany
    {
        return $this->morphedByMany('App\Domain\Course\Models\Course', 'termable');
    }

    public function lessons(): MorphToMany
    {
        return $this->morphedByMany('App\Domain\Course\Models\Lesson', 'termable');
    }

    public function getFullPathAttribute(): string
    {
        return $this->ancestors()
            ->pluck('name')
            ->push($this->name)
            ->implode(' > ');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public static function tree(): Collection
    {
        return static::with('children')
            ->root()
            ->ordered()
            ->get();
    }

    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    public function isLeaf(): bool
    {
        return $this->children()->count() === 0;
    }

    public function isChildOf(Term $parent): bool
    {
        return $this->parent_id === $parent->id;
    }

    public function isDescendantOf(Term $ancestor): bool
    {
        return $this->ancestors()->contains($ancestor);
    }
} 