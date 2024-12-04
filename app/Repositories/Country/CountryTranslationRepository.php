<?php

declare(strict_types=1);

namespace App\Repositories\Country;

use App\Contracts\Repositories\Country\CountryTranslationRepositoryInterface;
use App\Models\CountryTranslation;

final class CountryTranslationRepository implements CountryTranslationRepositoryInterface
{
    public function getAll(): array
    {
        return CountryTranslation::all()->toArray();
    }

    public function findById(int $id): ?CountryTranslation
    {
        return CountryTranslation::find($id);
    }

    public function create(array $data): CountryTranslation
    {
        return CountryTranslation::create($data);
    }

    public function update(int $id, array $data): ?CountryTranslation
    {
        $countryTranslation = CountryTranslation::find($id);
        if ($countryTranslation) {
            $countryTranslation->update($data);

            return $countryTranslation;
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $countryTranslation = CountryTranslation::find($id);
        if ($countryTranslation) {
            return $countryTranslation->delete();
        }

        return false;
    }
}
