<?php

declare(strict_types=1);

namespace App\Services\SocialMedia;

use App\Contracts\Repositories\SocialMedia\SocialMediaRepositoryInterface;

final class SocialMediaService
{
    private SocialMediaRepositoryInterface $repository;

    public function __construct(SocialMediaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function listAll(): array
    {
        return $this->repository->listAll();
    }

    public function create(array $data): void
    {
        $this->repository->create($data);
    }

    public function update(int $id, array $data): void
    {
        $this->repository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
