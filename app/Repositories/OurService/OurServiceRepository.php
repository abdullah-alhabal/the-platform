<?php

declare(strict_types=1);

namespace App\Repositories\OurService;

use App\Contracts\Repositories\OurService\OurServiceRepositoryInterface;
use App\DataTransferObjects\OurService\CreateOurServiceDto;
use App\DataTransferObjects\OurService\UpdateOurServiceDto;
use App\Models\OurService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class OurServiceRepository implements OurServiceRepositoryInterface
{
    public function __construct(
        private readonly Application $application
    ) {}

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return OurService::select(['id', 'image', 'created_at', 'updated_at'])
            ->with('translations:id,our_service_id,locale,title,text')
            ->latest()
            ->get();
    }

    /**
     * @param  int             $id
     * @return OurService|null
     */
    public function find(int $id): ?OurService
    {
        return OurService::select(['id', 'image', 'created_at', 'updated_at'])
            ->with('translations:id,our_service_id,locale,title,text')
            ->find($id);
    }

    /**
     * @param  int        $id
     * @return OurService
     */
    public function findOrFail(int $id): OurService
    {
        return OurService::select(['id', 'image', 'created_at', 'updated_at'])
            ->with('translations:id,our_service_id,locale,title,text')
            ->findOrFail($id);
    }

    /**
     * @param  CreateOurServiceDto $dto
     * @return OurService
     */
    public function create(CreateOurServiceDto $dto): OurService
    {
        return DB::transaction(function () use ($dto) {
            $ourService = OurService::create($dto->toArray());
            $this->saveTranslations($ourService, $dto->toArray());

            return $ourService;
        });
    }

    /**
     * @param  int                 $id
     * @param  UpdateOurServiceDto $dto
     * @return bool
     */
    public function update(int $id, UpdateOurServiceDto $dto): bool
    {
        return DB::transaction(function () use ($id, $dto) {
            $ourService = $this->findOrFail($id);
            $updated = $ourService->updateOrFail($dto->toArray());
            $this->saveTranslations($ourService, $dto->toArray());

            return $updated;
        });
    }

    /**
     * Delete (our service).
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $ourService = $this->findOrFail($id);

            return $ourService->deleteOrFail();
        });
    }

    private function saveTranslations(OurService $ourService, array $data): void
    {
        $locale = $this->application->getLocale();

        if ( ! empty($data["title_{$locale}"])) {
            $ourService->translations()->updateOrCreate(
                ['locale' => $locale],
                ['title' => $data["title_{$locale}"], 'text' => $data["text_{$locale}"] ?? '']
            );
        }
    }
}
