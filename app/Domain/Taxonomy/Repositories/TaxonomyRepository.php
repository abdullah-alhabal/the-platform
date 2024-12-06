<?php

namespace App\Domain\Taxonomy\Repositories;

use App\Domain\Taxonomy\Interfaces\TaxonomyRepositoryInterface;
use App\Domain\Taxonomy\Models\Taxonomy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TaxonomyRepository implements TaxonomyRepositoryInterface
{
    public function __construct(
        private readonly Taxonomy $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?Taxonomy
    {
        return $this->model->find($id);
    }

    public function findBySlug(string $slug): ?Taxonomy
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function create(array $data): Taxonomy
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        return $this->model->create($data);
    }

    public function update(Taxonomy $taxonomy, array $data): bool
    {
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        return $taxonomy->update($data);
    }

    public function delete(Taxonomy $taxonomy): bool
    {
        return $taxonomy->delete();
    }

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }

    public function getHierarchical(): Collection
    {
        return $this->model->hierarchical()->get();
    }

    public function getFlat(): Collection
    {
        return $this->model->flat()->get();
    }

    public function getTermsTree(Taxonomy $taxonomy): Collection
    {
        return $taxonomy->getTermsTree();
    }

    public function getTermsList(Taxonomy $taxonomy): array
    {
        return $taxonomy->getTermsList()->toArray();
    }
} 