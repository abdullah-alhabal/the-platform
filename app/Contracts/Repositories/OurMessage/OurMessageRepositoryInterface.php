<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\OurMessage;

use App\DataTransferObjects\OurMessage\CreateOurMessageDto;
use App\DataTransferObjects\OurMessage\UpdateOurMessageDto;
use App\Models\OurMessage;
use Illuminate\Database\Eloquent\Collection;

interface OurMessageRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?OurMessage;

    public function findOrFail(int $id): OurMessage;

    public function create(CreateOurMessageDto $dto): OurMessage;

    public function update(int $id, UpdateOurMessageDto $dto): bool;

    public function delete(int $id): bool;
}
