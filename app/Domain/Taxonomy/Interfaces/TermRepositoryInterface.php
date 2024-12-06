<?php

namespace App\Domain\Taxonomy\Interfaces;

use App\Domain\Taxonomy\Models\Term;
use App\Domain\Taxonomy\Models\Taxonomy;
use Illuminate\Database\Eloquent\Collection;

interface TermRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): ?Term;
    public function findBySlug(Taxonomy $taxonomy, string $slug): ?Term;
    public function create(array $data): Term;
    public function update(Term $term, array $data): bool;
    public function delete(Term $term): bool;
    public function getActive(): Collection;
    public function getByTaxonomy(Taxonomy $taxonomy): Collection;
    public function getRootTerms(Taxonomy $taxonomy): Collection;
    public function getChildren(Term $term): Collection;
    public function getAncestors(Term $term): Collection;
    public function reorder(array $order): bool;
    public function attachToModel(Term $term, Model $model): bool;
    public function detachFromModel(Term $term, Model $model): bool;
} 