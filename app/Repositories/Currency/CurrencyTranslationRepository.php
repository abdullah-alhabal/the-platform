<?php

declare(strict_types=1);

namespace App\Repositories\Currency;

use App\Contracts\Repositories\Currency\CurrencyTranslationRepositoryInterface;
use App\Models\CurrencyTranslation;

final class CurrencyTranslationRepository implements CurrencyTranslationRepositoryInterface
{
    public function getAll(): array
    {
        return CurrencyTranslation::all()->toArray();
    }

    public function findById(int $id): ?CurrencyTranslation
    {
        return CurrencyTranslation::find($id);
    }

    public function create(array $data): CurrencyTranslation
    {
        return CurrencyTranslation::create($data);
    }

    public function update(int $id, array $data): ?CurrencyTranslation
    {
        $currencyTranslation = CurrencyTranslation::find($id);
        if ($currencyTranslation) {
            $currencyTranslation->update($data);

            return $currencyTranslation;
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $currencyTranslation = CurrencyTranslation::find($id);
        if ($currencyTranslation) {
            return $currencyTranslation->delete();
        }

        return false;
    }
}
