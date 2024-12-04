<?php

declare(strict_types=1);

namespace App\Repositories\Country;

use App\Contracts\Repositories\Country\CountryRepositoryInterface;
use App\Models\Country;

final class CountryRepository implements CountryRepositoryInterface
{
    public function getAll(): array
    {
        return Country::all()->toArray();
    }

    public function findById(int $id): ?Country
    {
        return Country::find($id);
    }

    public function create(array $data): Country
    {
        return Country::create($data);
    }

    public function update(int $id, array $data): ?Country
    {
        $country = Country::find($id);
        if ($country) {
            $country->update($data);

            return $country;
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $country = Country::find($id);
        if ($country) {
            return $country->delete();
        }

        return false;
    }
}
