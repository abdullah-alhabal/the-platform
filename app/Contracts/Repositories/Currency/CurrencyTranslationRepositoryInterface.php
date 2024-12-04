<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Currency;

use App\Models\CurrencyTranslation;

interface CurrencyTranslationRepositoryInterface
{
    public function getAll(): array;

    public function findById(int $id): ?CurrencyTranslation;

    public function create(array $data): CurrencyTranslation;

    public function update(int $id, array $data): ?CurrencyTranslation;

    public function delete(int $id): bool;
}
