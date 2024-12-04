<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Contracts\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Collection;

final class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->userRepository->getAll();
    }

    public function store(array $data): bool
    {
        return $this->userRepository->store($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->userRepository->update($id, $data);
    }

    public function findById(int $id): ?array
    {
        return $this->userRepository->findById($id);
    }

    public function delete(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    public function search(array $data): Collection
    {
        return $this->userRepository->search($data);
    }

    public function getAllRoles(): Collection
    {
        return $this->userRepository->getAllRoles();
    }
}
