<?php

declare(strict_types=1);

namespace App\Repositories\OurPartner;

use App\Contracts\Repositories\OurPartner\OurPartnerRepositoryInterface;
use App\Models\OurPartner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class OurPartnerRepository implements OurPartnerRepositoryInterface
{
    public function __construct(
        private readonly Application $application
    ) {}

    public function all(): Collection
    {
        return OurPartner::with('translations')->latest()->get();
    }

    public function find(int $id): ?Model
    {
        return OurPartner::with('translations')->findOrFail($id);
    }

    public function create(array $data): Model
    {
        $partner = OurPartner::create($data);
        $this->saveTranslations($partner, $data);

        return $partner;
    }

    public function update(int $id, array $data): bool
    {
        $partner = $this->find($id);
        $updated = $partner->update($data);
        $this->saveTranslations($partner, $data);

        return $updated;
    }

    public function delete(int $id): bool
    {
        $partner = $this->find($id);

        return $partner->delete();
    }

    private function saveTranslations(OurPartner $partner, array $data): void
    {
        $locale = $this->application->getLocale();

        if ( ! empty($data["title_{$locale}"])) {
            $partner->translateOrNew($locale)->title = $data["title_{$locale}"];
        }

        $partner->save();
    }
}
