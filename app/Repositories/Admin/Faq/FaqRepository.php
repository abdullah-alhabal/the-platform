<?php

declare(strict_types=1);

namespace App\Repositories\Faq;

use App\Contracts\Repositories\Faq\FaqRepositoryInterface;
use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class FaqRepository implements FaqRepositoryInterface
{
    public function list(string $locale, ?string $search = null): Collection
    {
        return Faq::with(['translations' => function ($query) use ($locale): void {
            $query->where('locale', $locale);
        }])
            ->filter($search)
            ->orderBy('order')
            ->get();
    }

    public function create(array $data): Faq
    {
        return DB::transaction(function () use ($data) {
            $faq = Faq::create(['type' => $data['type'], 'order' => $data['order']]);
            foreach ($data['translations'] as $locale => $translation) {
                $faq->translations()->create(array_merge($translation, ['locale' => $locale]));
            }

            return $faq;
        });
    }

    public function update(int $id, array $data): Faq
    {
        return DB::transaction(function () use ($id, $data) {
            $faq = Faq::findOrFail($id);
            $faq->update(['type' => $data['type'], 'order' => $data['order']]);
            $faq->translations()->delete();
            foreach ($data['translations'] as $locale => $translation) {
                $faq->translations()->create(array_merge($translation, ['locale' => $locale]));
            }

            return $faq;
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $faq = Faq::findOrFail($id);

            return $faq->delete();
        });
    }
}
