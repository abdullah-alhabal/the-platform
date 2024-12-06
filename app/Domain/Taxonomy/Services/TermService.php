<?php

namespace App\Domain\Taxonomy\Services;

use App\Domain\Taxonomy\Interfaces\TermRepositoryInterface;
use App\Domain\Taxonomy\Models\Term;
use App\Domain\Taxonomy\Models\Taxonomy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TermService
{
    private const CACHE_PREFIX = 'term:';
    private const CACHE_TTL = 3600; // 1 hour

    public function __construct(
        private readonly TermRepositoryInterface $termRepository
    ) {}

    public function getAllTerms(): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'all',
            self::CACHE_TTL,
            fn() => $this->termRepository->all()
        );
    }

    public function getActiveTerms(): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'active',
            self::CACHE_TTL,
            fn() => $this->termRepository->getActive()
        );
    }

    public function findTerm(int $id): ?Term
    {
        return Cache::remember(
            self::CACHE_PREFIX . $id,
            self::CACHE_TTL,
            fn() => $this->termRepository->findById($id)
        );
    }

    public function findTermBySlug(Taxonomy $taxonomy, string $slug): ?Term
    {
        return Cache::remember(
            self::CACHE_PREFIX . $taxonomy->id . ':slug:' . $slug,
            self::CACHE_TTL,
            fn() => $this->termRepository->findBySlug($taxonomy, $slug)
        );
    }

    public function createTerm(array $data): Term
    {
        $term = $this->termRepository->create($data);
        $this->clearCache();
        return $term;
    }

    public function updateTerm(Term $term, array $data): bool
    {
        $updated = $this->termRepository->update($term, $data);
        if ($updated) {
            $this->clearCache();
        }
        return $updated;
    }

    public function deleteTerm(Term $term): bool
    {
        $deleted = $this->termRepository->delete($term);
        if ($deleted) {
            $this->clearCache();
        }
        return $deleted;
    }

    public function getTermsByTaxonomy(Taxonomy $taxonomy): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'taxonomy:' . $taxonomy->id,
            self::CACHE_TTL,
            fn() => $this->termRepository->getByTaxonomy($taxonomy)
        );
    }

    public function getRootTerms(Taxonomy $taxonomy): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'taxonomy:' . $taxonomy->id . ':root',
            self::CACHE_TTL,
            fn() => $this->termRepository->getRootTerms($taxonomy)
        );
    }

    public function getChildren(Term $term): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . $term->id . ':children',
            self::CACHE_TTL,
            fn() => $this->termRepository->getChildren($term)
        );
    }

    public function getAncestors(Term $term): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . $term->id . ':ancestors',
            self::CACHE_TTL,
            fn() => $this->termRepository->getAncestors($term)
        );
    }

    public function reorderTerms(array $order): bool
    {
        $reordered = $this->termRepository->reorder($order);
        if ($reordered) {
            $this->clearCache();
        }
        return $reordered;
    }

    public function attachToModel(Term $term, Model $model): bool
    {
        return $this->termRepository->attachToModel($term, $model);
    }

    public function detachFromModel(Term $term, Model $model): bool
    {
        return $this->termRepository->detachFromModel($term, $model);
    }

    private function clearCache(): void
    {
        Cache::tags([self::CACHE_PREFIX])->flush();
    }
} 