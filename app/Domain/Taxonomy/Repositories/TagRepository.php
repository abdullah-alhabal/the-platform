<?php

namespace App\Domain\Taxonomy\Repositories;

use App\Domain\Taxonomy\Interfaces\TagRepositoryInterface;
use App\Domain\Taxonomy\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TagRepository implements TagRepositoryInterface
{
    public function __construct(
        private readonly Tag $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?Tag
    {
        return $this->model->find($id);
    }

    public function findBySlug(string $slug): ?Tag
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function findByName(string $name): ?Tag
    {
        return $this->model->where('name', $name)->first();
    }

    public function create(array $data): Tag
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        return $this->model->create($data);
    }

    public function update(Tag $tag, array $data): bool
    {
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        return $tag->update($data);
    }

    public function delete(Tag $tag): bool
    {
        return $tag->delete();
    }

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }

    public function getByType(string $type): Collection
    {
        return $this->model->ofType($type)->get();
    }

    public function findOrCreateByName(string $name, string $type = 'general'): Tag
    {
        return $this->model->findOrCreateByName($name, $type);
    }

    public function attachToModel(Tag $tag, Model $model): bool
    {
        try {
            $model->tags()->attach($tag->id);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function detachFromModel(Tag $tag, Model $model): bool
    {
        try {
            $model->tags()->detach($tag->id);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function syncWithModel(array $tags, Model $model): void
    {
        $tagIds = collect($tags)->map(function ($tag) {
            if (is_numeric($tag)) {
                return $tag;
            }
            return $this->findOrCreateByName($tag)->id;
        })->toArray();

        $model->tags()->sync($tagIds);
    }

    public function getPopular(int $limit = 10): Collection
    {
        return $this->model
            ->withCount('courses', 'lessons')
            ->orderByDesc('courses_count')
            ->orderByDesc('lessons_count')
            ->limit($limit)
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
    }
} 