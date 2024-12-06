<?php

namespace App\Domain\Identity\Repositories;

use App\Domain\Identity\DTOs\Auth\RegisterDto;
use App\Domain\Identity\Interfaces\UserRepositoryInterface;
use App\Domain\Identity\Models\Admin;
use App\Domain\Identity\Models\Marketer;
use App\Domain\Identity\Models\Student;
use App\Domain\Identity\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $model
    ) {}

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByPhone(string $phone): ?User
    {
        return $this->model->where('phone', $phone)->first();
    }

    public function create(RegisterDto $dto): User
    {
        $user = $this->model->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'phone' => $dto->phone,
            'type' => $dto->type,
        ]);

        match ($dto->type->value) {
            'admin' => Admin::create([
                'user_id' => $user->id,
                'department' => $dto->department,
                'position' => $dto->position,
            ]),
            'teacher' => Teacher::create([
                'user_id' => $user->id,
                'bio' => $dto->bio,
                'expertise' => $dto->expertise,
            ]),
            'student' => Student::create([
                'user_id' => $user->id,
                'education_level' => $dto->education_level,
                'interests' => $dto->interests,
            ]),
            'marketer' => Marketer::create([
                'user_id' => $user->id,
                'company_name' => $dto->company_name,
                'website' => $dto->website,
                'commission_rate' => $dto->commission_rate,
            ]),
        };

        return $user->refresh();
    }

    public function update(User $user, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function search(string $query): Collection
    {
        return $this->model->where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();
    }

    public function getActiveUsers(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    public function getInactiveUsers(): Collection
    {
        return $this->model->where('is_active', false)->get();
    }

    public function getUsersByType(string $type): Collection
    {
        return $this->model->where('type', $type)->get();
    }

    public function verifyEmail(User $user): bool
    {
        return $user->update(['email_verified_at' => now()]);
    }

    public function verifyPhone(User $user): bool
    {
        return $user->update(['phone_verified_at' => now()]);
    }
}
