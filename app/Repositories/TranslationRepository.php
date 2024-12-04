<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Translation;

final class TranslationRepository
{
    public function getAllByLanguage(string $lang): array
    {
        return Translation::where('language', $lang)->pluck('value', 'key')->toArray();
    }

    public function update(string $lang, array $data): void
    {
        foreach ($data as $key => $value) {
            Translation::updateOrCreate(
                ['language' => $lang, 'key' => $key],
                ['value' => $value],
            );
        }
    }
}
