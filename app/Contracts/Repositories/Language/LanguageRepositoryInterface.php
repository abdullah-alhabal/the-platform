<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Language;

use App\Models\Language;

interface LanguageRepositoryInterface
{
    public function getAll(array $filters = []): iterable;

    public function findById(int $id): ?Language;

    public function create(array $data): Language;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
