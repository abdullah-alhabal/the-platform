<?php

namespace App\Domain\Taxonomy\Services;

use App\Domain\Taxonomy\Interfaces\TaxonomyRepositoryInterface;
use App\Domain\Taxonomy\Models\Taxonomy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TaxonomyService
{
    private const CACHE_PREFIX = 'taxonomy:';
    private const CACHE_TTL = 3600; // 1 hour

    public function __construct(
        private readonly TaxonomyRepositoryInterface $taxonomyRepository
    ) {}

    public function getAllTaxonomies(): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'all',
            self::CACHE_TTL,
            fn() => $this->taxonomyRepository->all()
        );
    }

    public function getActiveTaxonomies(): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'active',
            self::CACHE_TTL,
            fn() => $this->taxonomyRepository->getActive()
        );
    }

    public function getHierarchicalTaxonomies(): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'hierarchical',
            self::CACHE_TTL,
            fn() => $this->taxonomyRepository->getHierarchical()
        );
    }

    public function getFlatTaxonomies(): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'flat',
            self::CACHE_TTL,
            fn() => $this->taxonomyRepository->getFlat()
        );
    }

    public function findTaxonomy(int $id): ?Taxonomy
    {
        return Cache::remember(
            self::CACHE_PREFIX . $id,
            self::CACHE_TTL,
            fn() => $this->taxonomyRepository->findById($id)
        );
    }

    public function findTaxonomyBySlug(string $slug): ?Taxonomy
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'slug:' . $slug,
            self::CACHE_TTL,
            fn() => $this->taxonomyRepository->findBySlug($slug)
        );
    }

    public function createTaxonomy(array $data): Taxonomy
    {
        $taxonomy = $this->taxonomyRepository->create($data);
        $this->clearCache();
        return $taxonomy;
    }

    public function updateTaxonomy(Taxonomy $taxonomy, array $data): bool
    {
        $updated = $this->taxonomyRepository->update($taxonomy, $data);
        if ($updated) {
            $this->clearCache();
        }
        return $updated;
    }

    public function deleteTaxonomy(Taxonomy $taxonomy): bool
    {
        $deleted = $this->taxonomyRepository->delete($taxonomy);
        if ($deleted) {
            $this->clearCache();
        }
        return $deleted;
    }

    public function getTermsTree(Taxonomy $taxonomy): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . $taxonomy->id . ':terms:tree',
            self::CACHE_TTL,
            fn() => $this->taxonomyRepository->getTermsTree($taxonomy)
        );
    }

    public function getTermsList(Taxonomy $taxonomy): array
    {
        return Cache::remember(
            self::CACHE_PREFIX . $taxonomy->id . ':terms:list',
            self::CACHE_TTL,
            fn() => $this->taxonomyRepository->getTermsList($taxonomy)
        );
    }

    private function clearCache(): void
    {
        Cache::tags([self::CACHE_PREFIX])->flush();
    }
} 