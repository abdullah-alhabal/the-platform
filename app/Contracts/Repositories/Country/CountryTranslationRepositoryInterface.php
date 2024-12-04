<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Country;

use App\Models\CountryTranslation;

interface CountryTranslationRepositoryInterface
{
    public function getAll(): array;

    public function findById(int $id): ?CountryTranslation;

    public function create(array $data): CountryTranslation;

    public function update(int $id, array $data): ?CountryTranslation;

    public function delete(int $id): bool;
}
