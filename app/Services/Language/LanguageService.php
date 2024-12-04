<?php

declare(strict_types=1);

namespace App\Services\Language;

use App\Contracts\Repositories\Language\LanguageRepositoryInterface;
use App\Models\Language;
use Exception;

final class LanguageService
{
    public function __construct(
        private readonly LanguageRepositoryInterface $languageRepository
    ) {}

    public function getAllLanguages(array $filters = []): iterable
    {
        return $this->languageRepository->getAll($filters);
    }

    public function getLanguageById(int $id): ?Language
    {
        return $this->languageRepository->findById($id);
    }

    public function createLanguage(array $data): Language
    {
        return $this->languageRepository->create($data);
    }

    public function updateLanguage(int $id, array $data): bool
    {
        return $this->languageRepository->update($id, $data);
    }

    public function deleteLanguage(int $id): void
    {
        $language = $this->languageRepository->findById($id);

        if ($language->is_default) {
            throw new Exception('Default language cannot be deleted.');
        }

        $this->languageRepository->delete($id);
    }
}
