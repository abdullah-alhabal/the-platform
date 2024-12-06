<?php

namespace App\Domain\Taxonomy\Interfaces;

use App\Domain\Taxonomy\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TagRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): ?Tag;
    public function findBySlug(string $slug): ?Tag;
    public function findByName(string $name): ?Tag;
    public function create(array $data): Tag;
    public function update(Tag $tag, array $data): bool;
    public function delete(Tag $tag): bool;
    public function getActive(): Collection;
    public function getByType(string $type): Collection;
    public function findOrCreateByName(string $name, string $type = 'general'): Tag;
    public function attachToModel(Tag $tag, Model $model): bool;
    public function detachFromModel(Tag $tag, Model $model): bool;
    public function syncWithModel(array $tags, Model $model): void;
    public function getPopular(int $limit = 10): Collection;
    public function search(string $query): Collection;
} 