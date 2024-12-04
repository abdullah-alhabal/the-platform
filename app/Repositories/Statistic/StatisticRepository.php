<?php

declare(strict_types=1);

namespace App\Repositories\Statistic;

use App\Contracts\Repositories\Statistic\StatisticRepositoryInterface;
use App\DataTransferObjects\Statistic\CreateStatisticDto;
use App\DataTransferObjects\Statistic\UpdateStatisticDto;
use App\Models\Statistic;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class StatisticRepository implements StatisticRepositoryInterface
{
    public function __construct(
        private readonly Application $application
    ) {}

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return Statistic::select(['id', 'image', 'count', 'created_at', 'updated_at'])
            ->with('translations:id,statistic_id,locale,title')
            ->latest()
            ->get();
    }

    /**
     * @param  int             $id
     * @return Statistic|null
     */
    public function find(int $id): ?Statistic
    {
        return Statistic::select(['id', 'image', 'created_at', 'updated_at'])
            ->with('translations:id,statistic_id,locale,title,description')
            ->find($id);
    }

    /**
     * @param  int        $id
     * @return Statistic
     */
    public function findOrFail(int $id): Statistic
    {
        return Statistic::select(['id', 'image', 'created_at', 'updated_at'])
            ->with('translations:id,statistic_id,locale,title,description')
            ->findOrFail($id);
    }

    /**
     * @param  CreateStatisticDto $dto
     * @return Statistic
     */
    public function create(CreateStatisticDto $dto): Statistic
    {
        return DB::transaction(function () use ($dto) {
            $Statistic = Statistic::create($dto->toArray());
            $this->saveTranslations($Statistic, $dto->toArray());

            return $Statistic;
        });
    }

    /**
     * @param  int                 $id
     * @param  UpdateStatisticDto $dto
     * @return bool
     */
    public function update(int $id, UpdateStatisticDto $dto): bool
    {
        return DB::transaction(function () use ($id, $dto) {
            $Statistic = $this->findOrFail($id);
            $updated = $Statistic->updateOrFail($dto->toArray());
            $this->saveTranslations($Statistic, $dto->toArray());

            return $updated;
        });
    }

    /**
     * Delete statistic.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $Statistic = $this->findOrFail($id);

            return $Statistic->deleteOrFail();
        });
    }

    private function saveTranslations(Statistic $Statistic, array $data): void
    {
        $locale = $this->application->getLocale();

        if (! empty($data["title_{$locale}"])) {
            $Statistic->translations()->updateOrCreate(
                ['locale' => $locale],
                ['title' => $data["title_{$locale}"], 'description' => $data["description_{$locale}"] ?? '']
            );
        }
    }
}
