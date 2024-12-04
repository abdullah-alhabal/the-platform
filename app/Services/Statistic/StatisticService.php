<?php

declare(strict_types=1);

namespace App\Services\Statistic;

use App\Contracts\Repositories\Statistic\StatisticRepositoryInterface;
use App\DataTransferObjects\Statistic\CreateStatisticDto;
use App\DataTransferObjects\Statistic\UpdateStatisticDto;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class StatisticService
{
    public function __construct(
        private readonly StatisticRepositoryInterface $StatisticRepository
    ) {}

    /**
     * Get all Statistic.
     *
     * @return Collection
     */
    public function getAllStatistics(): Collection
    {
        return $this->StatisticRepository->all();
    }

    /**
     * Find an Statistic by id.
     *
     * @param  int             $id
     * @return Statistic|null
     */
    public function find(int $id): ?Statistic
    {
        return $this->StatisticRepository->find($id);
    }

    /**
     * Create a new Statistic.
     *
     * @param  CreateStatisticDto $dto
     * @return Statistic
     */
    public function create(CreateStatisticDto $dto): Statistic
    {
        if ($dto->image instanceof UploadedFile) {
            $dto->image = $dto->image->store('images/statistic', 'public');
        }

        return $this->StatisticRepository->create($dto);
    }

    /**
     * Update an existing Statistic.
     *
     * @param  int                 $id
     * @param  UpdateStatisticDto $dto
     * @return bool
     */
    public function update(int $id, UpdateStatisticDto $dto): bool
    {
        $Statistic = $this->StatisticRepository->findOrFail($id);

        if ($dto->image && $Statistic->image) {
            Storage::disk('public')->delete($Statistic->image);
        }

        if ($dto->image instanceof UploadedFile) {
            $dto->image = $dto->image->store('images/statistic', 'public');
        }

        return $this->StatisticRepository->update($id, $dto);
    }

    /**
     * Delete an Statistic.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $Statistic = $this->StatisticRepository->findOrFail($id);

        if ($Statistic->image) {
            Storage::disk('public')->delete($Statistic->image);
        }

        return $this->StatisticRepository->delete($id);
    }
}
