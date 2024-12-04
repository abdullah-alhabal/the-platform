<?php

declare(strict_types=1);

namespace App\Repositories\Language;

use App\Contracts\Repositories\Language\LanguageRepositoryInterface;
use App\Models\Language;

final class LanguageRepository implements LanguageRepositoryInterface
{
    public function getAll(array $filters = []): iterable
    {
        $query = Language::query();

        if ( ! empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->get();
    }

    public function findById(int $id): ?Language
    {
        return Language::find($id);
    }

    public function create(array $data): Language
    {
        return Language::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $language = $this->findById($id);

        if ( ! $language) {
            return false;
        }

        return $language->update($data);
    }

    public function delete(int $id): bool
    {
        $language = $this->findById($id);

        if ( ! $language) {
            return false;
        }

        return $language->delete();
    }
}
