<?php

declare(strict_types=1);

namespace App\Services\Country;

use App\Contracts\Repositories\Country\CountryRepositoryInterface;
use App\Models\Country;

final class CountryService
{
    public function __construct(
        private readonly CountryRepositoryInterface $countryRepository,
    ) {}

    public function getAllCountries(): array
    {
        return $this->countryRepository->getAll();
    }

    public function getCountryById(int $id): ?Country
    {
        return $this->countryRepository->findById($id);
    }

    public function createCountry(array $data): Country
    {
        return $this->countryRepository->create($data);
    }

    public function updateCountry(int $id, array $data): ?Country
    {
        return $this->countryRepository->update($id, $data);
    }

    public function deleteCountry(int $id): bool
    {
        return $this->countryRepository->delete($id);
    }
}
