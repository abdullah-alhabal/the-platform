<?php

declare(strict_types=1);

namespace App\Repositories\SocialMedia;

use App\Contracts\Repositories\SocialMedia\SocialMediaRepositoryInterface;
use App\Models\SocialMedia;

final class SocialMediaRepository implements SocialMediaRepositoryInterface
{
    public function listAll(): array
    {
        return SocialMedia::with('translations')->get()->toArray();
    }

    public function create(array $data): void
    {
        $socialMedia = SocialMedia::create($data);
        foreach ($data['translations'] as $locale => $translation) {
            $socialMedia->translations()->create([
                'locale' => $locale,
                'name' => $translation,
            ]);
        }
    }

    public function update(int $id, array $data): void
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->update($data);
        foreach ($data['translations'] as $locale => $translation) {
            $socialMedia->translations()->updateOrCreate(
                ['locale' => $locale],
                ['name' => $translation]
            );
        }
    }

    public function delete(int $id): void
    {
        SocialMedia::findOrFail($id)->delete();
    }
}
