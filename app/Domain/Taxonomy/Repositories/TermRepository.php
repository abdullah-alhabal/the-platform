<?php

namespace App\Domain\Taxonomy\Repositories;

use App\Domain\Taxonomy\Interfaces\TermRepositoryInterface;
use App\Domain\Taxonomy\Models\Term;
use App\Domain\Taxonomy\Models\Taxonomy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TermRepository implements TermRepositoryInterface
{
    public function __construct(
        private readonly Term $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?Term
    {
        return $this->model->find($id);
    }

    public function findBySlug(Taxonomy $taxonomy, string $slug): ?Term
    {
        return $this->model
            ->where('taxonomy_id', $taxonomy->id)
            ->where('slug', $slug)
            ->first();
    }

    public function create(array $data): Term
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        return $this->model->create($data);
    }

    public function update(Term $term, array $data): bool
    {
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        return $term->update($data);
    }

    public function delete(Term $term): bool
    {
        return $term->delete();
    }

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }

    public function getByTaxonomy(Taxonomy $taxonomy): Collection
    {
        return $this->model->where('taxonomy_id', $taxonomy->id)->get();
    }

    public function getRootTerms(Taxonomy $taxonomy): Collection
    {
        return $this->model
            ->where('taxonomy_id', $taxonomy->id)
            ->whereNull('parent_id')
            ->ordered()
            ->get();
    }

    public function getChildren(Term $term): Collection
    {
        return $term->children()->ordered()->get();
    }

    public function getAncestors(Term $term): Collection
    {
        return $term->ancestors();
    }

    public function reorder(array $order): bool
    {
        try {
            foreach ($order as $position => $termId) {
                $this->model->where('id', $termId)->update(['order' => $position]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function attachToModel(Term $term, Model $model): bool
    {
        try {
            $model->terms()->attach($term->id);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function detachFromModel(Term $term, Model $model): bool
    {
        try {
            $model->terms()->detach($term->id);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
} 