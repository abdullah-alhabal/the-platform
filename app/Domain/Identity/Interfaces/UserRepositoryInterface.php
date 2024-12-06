<?php

namespace App\Domain\Identity\Interfaces;

use App\Domain\Identity\DTOs\Auth\RegisterDto;
use App\Domain\Identity\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function findByPhone(string $phone): ?User;
    public function create(RegisterDto $dto): User;
    public function update(User $user, array $data): bool;
    public function delete(User $user): bool;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function search(string $query): Collection;
    public function getActiveUsers(): Collection;
    public function getInactiveUsers(): Collection;
    public function getUsersByType(string $type): Collection;
    public function verifyEmail(User $user): bool;
    public function verifyPhone(User $user): bool;
} 