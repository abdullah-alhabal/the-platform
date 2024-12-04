<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Faq;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

interface FaqRepositoryInterface
{
    public function list(string $locale, ?string $search = null): Collection;

    public function create(array $data): Faq;

    public function update(int $id, array $data): Faq;

    public function delete(int $id): bool;
}
