<?php

declare(strict_types=1);


namespace App\Repositories\WorkStep;

use App\Contracts\Repositories\WorkStep\WorkStepRepositoryInterface;
use App\DataTransferObjects\WorkStep\CreateWorkStepDto;
use App\DataTransferObjects\WorkStep\UpdateWorkStepDto;
use App\Models\WorkStep;
use Illuminate\Database\Eloquent\Collection;

class WorkStepRepository implements WorkStepRepositoryInterface
{

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        // TODO: Implement all() method.
    }

    /**
     * @param int $id
     *
     * @return WorkStep|null
     */
    public function find(int $id): WorkStep|null
    {
        // TODO: Implement find() method.
    }

    /**
     * @param int $id
     *
     * @return WorkStep
     */
    public function findOrFail(int $id): WorkStep
    {
        // TODO: Implement findOrFail() method.
    }

    /**
     * @param CreateWorkStepDto $dto
     *
     * @return WorkStep
     */
    public function create(CreateWorkStepDto $dto): WorkStep
    {
        // TODO: Implement create() method.
    }

    /**
     * @param int               $id
     * @param UpdateWorkStepDto $dto
     *
     * @return bool
     */
    public function update(int $id, UpdateWorkStepDto $dto): bool
    {
        // TODO: Implement update() method.
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }
}
