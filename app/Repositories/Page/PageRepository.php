<?php

declare(strict_types=1);

namespace App\Repositories\Page;

use App\Contracts\Repositories\Page\PageRepositoryInterface;
use App\Models\Page;

final class PageRepository implements PageRepositoryInterface
{
    public function getPageBySlug(string $slug, string $locale): array
    {
        $page = Page::with(['translations' => fn ($q) => $q->where('locale', $locale)])
            ->where('slug', $slug)
            ->firstOrFail();

        return $page->toArray();
    }
}
