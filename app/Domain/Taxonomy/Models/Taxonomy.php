<?php

namespace App\Domain\Taxonomy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taxonomy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_hierarchical',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_hierarchical' => 'boolean',
        'is_active' => 'boolean',
        'meta_keywords' => 'array',
    ];

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class);
    }

    public function rootTerms(): HasMany
    {
        return $this->terms()->whereNull('parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHierarchical($query)
    {
        return $query->where('is_hierarchical', true);
    }

    public function scopeFlat($query)
    {
        return $query->where('is_hierarchical', false);
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    public function getTermsTree()
    {
        return $this->rootTerms()->with('children')->get();
    }

    public function getTermsList()
    {
        return $this->terms()->ordered()->pluck('name', 'id');
    }

    public function isHierarchical(): bool
    {
        return $this->is_hierarchical;
    }
}
