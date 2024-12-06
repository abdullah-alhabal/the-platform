<?php

namespace App\Domain\Taxonomy\Services;

use App\Domain\Taxonomy\Interfaces\TagRepositoryInterface;
use App\Domain\Taxonomy\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TagService
{
    private const CACHE_PREFIX = 'tag:';
    private const CACHE_TTL = 3600; // 1 hour

    public function __construct(
        private readonly TagRepositoryInterface $tagRepository
    ) {}

    public function getAllTags(): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'all',
            self::CACHE_TTL,
            fn() => $this->tagRepository->all()
        );
    }

    public function getActiveTags(): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'active',
            self::CACHE_TTL,
            fn() => $this->tagRepository->getActive()
        );
    }

    public function findTag(int $id): ?Tag
    {
        return Cache::remember(
            self::CACHE_PREFIX . $id,
            self::CACHE_TTL,
            fn() => $this->tagRepository->findById($id)
        );
    }

    public function findTagBySlug(string $slug): ?Tag
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'slug:' . $slug,
            self::CACHE_TTL,
            fn() => $this->tagRepository->findBySlug($slug)
        );
    }

    public function findTagByName(string $name): ?Tag
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'name:' . $name,
            self::CACHE_TTL,
            fn() => $this->tagRepository->findByName($name)
        );
    }

    public function createTag(array $data): Tag
    {
        $tag = $this->tagRepository->create($data);
        $this->clearCache();
        return $tag;
    }

    public function updateTag(Tag $tag, array $data): bool
    {
        $updated = $this->tagRepository->update($tag, $data);
        if ($updated) {
            $this->clearCache();
        }
        return $updated;
    }

    public function deleteTag(Tag $tag): bool
    {
        $deleted = $this->tagRepository->delete($tag);
        if ($deleted) {
            $this->clearCache();
        }
        return $deleted;
    }

    public function getTagsByType(string $type): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'type:' . $type,
            self::CACHE_TTL,
            fn() => $this->tagRepository->getByType($type)
        );
    }

    public function findOrCreateTagByName(string $name, string $type = 'general'): Tag
    {
        $tag = $this->tagRepository->findOrCreateByName($name, $type);
        $this->clearCache();
        return $tag;
    }

    public function attachToModel(Tag $tag, Model $model): bool
    {
        return $this->tagRepository->attachToModel($tag, $model);
    }

    public function detachFromModel(Tag $tag, Model $model): bool
    {
        return $this->tagRepository->detachFromModel($tag, $model);
    }

    public function syncWithModel(array $tags, Model $model): void
    {
        $this->tagRepository->syncWithModel($tags, $model);
    }

    public function getPopularTags(int $limit = 10): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'popular:' . $limit,
            self::CACHE_TTL,
            fn() => $this->tagRepository->getPopular($limit)
        );
    }

    public function searchTags(string $query): Collection
    {
        return $this->tagRepository->search($query);
    }

    private function clearCache(): void
    {
        Cache::tags([self::CACHE_PREFIX])->flush();
    }
} 