<?php

declare(strict_types=1);


namespace App\Contracts\Repositories\WorkStep;

use App\DataTransferObjects\WorkStep\CreateWorkStepDto;
use App\DataTransferObjects\WorkStep\UpdateWorkStepDto;
use App\Models\WorkStep;
use Illuminate\Database\Eloquent\Collection;

interface WorkStepRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     *
     * @return WorkStep|null
     */
    public function find(int $id): WorkStep|null;

    /**
     * @param int $id
     *
     * @return WorkStep
     */
    public function findOrFail(int $id): WorkStep;

    /**
     * @param CreateWorkStepDto $dto
     *
     * @return WorkStep
     */
    public function create(CreateWorkStepDto $dto): WorkStep;

    /**
     * @param int                 $id
     * @param UpdateWorkStepDto $dto
     *
     * @return bool
     */
    public function update(int $id, UpdateWorkStepDto $dto): bool;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool;
}
