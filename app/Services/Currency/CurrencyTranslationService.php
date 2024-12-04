<?php

declare(strict_types=1);

namespace App\Services\Currency;

use App\Contracts\Repositories\Currency\CurrencyTranslationRepositoryInterface;
use App\Models\CurrencyTranslation;

final class CurrencyTranslationService
{
    /**
     * @param CurrencyTranslationRepositoryInterface $currencyTranslationRepository
     */
    public function __construct(
        private readonly CurrencyTranslationRepositoryInterface $currencyTranslationRepository
    ) {}

    /**
     * @return array
     */
    public function getAllTranslations(): array
    {
        return $this->currencyTranslationRepository->getAll();
    }

    /**
     * @param  int                      $id
     * @return CurrencyTranslation|null
     */
    public function getTranslationById(int $id): ?CurrencyTranslation
    {
        return $this->currencyTranslationRepository->findById($id);
    }

    /**
     * @param  array               $data
     * @return CurrencyTranslation
     */
    public function createTranslation(array $data): CurrencyTranslation
    {
        return $this->currencyTranslationRepository->create($data);
    }

    /**
     * @param  int                      $id
     * @param  array                    $data
     * @return CurrencyTranslation|null
     */
    public function updateTranslation(int $id, array $data): ?CurrencyTranslation
    {
        return $this->currencyTranslationRepository->update($id, $data);
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function deleteTranslation(int $id): bool
    {
        return $this->currencyTranslationRepository->delete($id);
    }
}
