<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Contracts\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository.
 */
final class UserRepository implements UserRepositoryInterface
{
    /**
     * Get all users.
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * Store a new user.
     */
    public function store(array $data): bool
    {
        $user = new User($data);

        return $user->save();
    }

    /**
     * Update an existing user.
     */
    public function update(int $id, array $data): bool
    {
        $user = User::findOrFail($id);

        return $user->update($data);
    }

    /**
     * Find a user by ID.
     */
    public function findById(int $id): ?array
    {
        $user = User::find($id);

        if ($user) {
            return $user->toArray();
        }

        return null;
    }

    /**
     * Delete a user by ID.
     */
    public function delete(int $id): bool
    {
        $user = User::findOrFail($id);

        return $user->delete();
    }

    /**
     * Search for users based on criteria.
     */
    public function search(array $data): Collection
    {
        $search = $data['search'];

        return User::where(static function ($query) use ($search): void {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->get();
    }

    /**
     * Get all distinct roles.
     */
    public function getAllRoles(): Collection
    {
        return DB::table('roles')->select('name')->distinct()->get();
    }
}
