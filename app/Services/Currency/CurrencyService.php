<?php

declare(strict_types=1);

namespace App\Services\Currency;

use App\Contracts\Repositories\Currency\CurrencyRepositoryInterface;
use App\Models\Currency;

final class CurrencyService
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository
    ) {}

    /**
     * @return array
     */
    public function getAllCurrencies(): array
    {
        return $this->currencyRepository->getAll();
    }

    /**
     * @param  int           $id
     * @return Currency|null
     */
    public function getCurrencyById(int $id): ?Currency
    {
        return $this->currencyRepository->findById($id);
    }

    /**
     * @param  array    $data
     * @return Currency
     */
    public function createCurrency(array $data): Currency
    {
        return $this->currencyRepository->create($data);
    }

    /**
     * @param  int           $id
     * @param  array         $data
     * @return Currency|null
     */
    public function updateCurrency(int $id, array $data): ?Currency
    {
        return $this->currencyRepository->update($id, $data);
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function deleteCurrency(int $id): bool
    {
        return $this->currencyRepository->delete($id);
    }
}
