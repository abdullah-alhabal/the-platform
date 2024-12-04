<?php

declare(strict_types=1);

namespace App\Repositories\Currency;

use App\Contracts\Repositories\Currency\CurrencyRepositoryInterface;
use App\Models\Currency;

final class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function getAll(): array
    {
        return Currency::all()->toArray();
    }

    public function findById(int $id): ?Currency
    {
        return Currency::find($id);
    }

    public function create(array $data): Currency
    {
        return Currency::create($data);
    }

    public function update(int $id, array $data): ?Currency
    {
        $currency = Currency::find($id);
        if ($currency) {
            $currency->update($data);

            return $currency;
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $currency = Currency::find($id);
        if ($currency) {
            return $currency->delete();
        }

        return false;
    }
}
