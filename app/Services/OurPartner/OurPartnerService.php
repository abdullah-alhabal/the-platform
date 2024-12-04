<?php

declare(strict_types=1);

namespace App\Services\OurPartner;

use App\Contracts\Repositories\OurPartner\OurPartnerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class OurPartnerService
{
    public function __construct(
        private readonly OurPartnerRepositoryInterface $repository
    ) {}

    public function listAll(): Collection
    {
        return $this->repository->all();
    }

    public function find(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
