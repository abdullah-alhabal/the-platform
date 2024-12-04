<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\User;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getAll(): Collection;

    public function store(array $data): bool;

    public function update(int $id, array $data): bool;

    public function findById(int $id): ?array;

    public function delete(int $id): bool;

    public function search(array $data): Collection;

    public function getAllRoles(): Collection;
}
