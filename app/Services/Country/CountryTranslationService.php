<?php

declare(strict_types=1);

namespace App\Services\Country;

use App\Contracts\Repositories\Country\CountryTranslationRepositoryInterface;
use App\Models\CountryTranslation;

final class CountryTranslationService
{
    public function __construct(
        private readonly CountryTranslationRepositoryInterface $countryTranslationRepository,
    ) {}

    public function getAllTranslations(): array
    {
        return $this->countryTranslationRepository->getAll();
    }

    public function getTranslationById(int $id): ?CountryTranslation
    {
        return $this->countryTranslationRepository->findById($id);
    }

    public function createTranslation(array $data): CountryTranslation
    {
        return $this->countryTranslationRepository->create($data);
    }

    public function updateTranslation(int $id, array $data): ?CountryTranslation
    {
        return $this->countryTranslationRepository->update($id, $data);
    }

    public function deleteTranslation(int $id): bool
    {
        return $this->countryTranslationRepository->delete($id);
    }
}
