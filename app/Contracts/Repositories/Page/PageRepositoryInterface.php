<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Page;

interface PageRepositoryInterface
{
    public function getPageBySlug(string $slug, string $locale): array;
}
