<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Country;

use App\Models\Country;

interface CountryRepositoryInterface
{
    public function getAll(): array;

    public function findById(int $id): ?Country;

    public function create(array $data): Country;

    public function update(int $id, array $data): ?Country;

    public function delete(int $id): bool;
}
