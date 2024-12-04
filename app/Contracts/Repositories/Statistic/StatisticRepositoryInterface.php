<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Statistic;

use App\DataTransferObjects\Statistic\CreateStatisticDto;
use App\DataTransferObjects\Statistic\UpdateStatisticDto;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Collection;

interface StatisticRepositoryInterface
{
    public function all(): Collection;

    public function create(CreateStatisticDto $dto): Statistic;

    public function find(int $id): ?Statistic;
    public function findOrFail(int $id): ?Statistic;

    public function update(int $id, UpdateStatisticDto $dto): bool;

    public function delete(int $id): bool;
}
