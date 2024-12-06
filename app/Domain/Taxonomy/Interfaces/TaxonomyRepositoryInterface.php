<?php

namespace App\Domain\Taxonomy\Interfaces;

use App\Domain\Taxonomy\Models\Taxonomy;
use Illuminate\Database\Eloquent\Collection;

interface TaxonomyRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): ?Taxonomy;
    public function findBySlug(string $slug): ?Taxonomy;
    public function create(array $data): Taxonomy;
    public function update(Taxonomy $taxonomy, array $data): bool;
    public function delete(Taxonomy $taxonomy): bool;
    public function getActive(): Collection;
    public function getHierarchical(): Collection;
    public function getFlat(): Collection;
    public function getTermsTree(Taxonomy $taxonomy): Collection;
    public function getTermsList(Taxonomy $taxonomy): array;
} 