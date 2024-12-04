<?php

declare(strict_types=1);

namespace App\Services\Page;

use App\Contracts\Repositories\Page\PageRepositoryInterface;

final class PageService
{
    public function __construct(
        private readonly PageRepositoryInterface $repository
    ) {}

    public function getPage(string $slug, string $locale): array
    {
        return $this->repository->getPageBySlug($slug, $locale);
    }
}
