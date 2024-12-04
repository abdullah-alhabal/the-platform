<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Currency;

use App\Models\Currency;

interface CurrencyRepositoryInterface
{
    public function getAll(): array;

    public function findById(int $id): ?Currency;

    public function create(array $data): Currency;

    public function update(int $id, array $data): ?Currency;

    public function delete(int $id): bool;
}
