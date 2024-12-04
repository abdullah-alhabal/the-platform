<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\OurService;

use App\DataTransferObjects\OurService\CreateOurServiceDto;
use App\DataTransferObjects\OurService\UpdateOurServiceDto;
use App\Models\OurService;
use Illuminate\Database\Eloquent\Collection;

interface OurServiceRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): OurService|null;

    public function findOrFail(int $id): OurService;

    public function create(CreateOurServiceDto $dto): OurService;

    public function update(int $id, UpdateOurServiceDto $dto): bool;

    public function delete(int $id): bool;
}
