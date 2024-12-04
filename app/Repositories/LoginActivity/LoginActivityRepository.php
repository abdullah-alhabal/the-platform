<?php

declare(strict_types=1);

namespace App\Repositories\LoginActivity;

use App\Contracts\Repositories\LoginActivity\LoginActivityRepositoryInterface;
use App\Models\LoginActivity;
use Illuminate\Database\Eloquent\Collection;

final class LoginActivityRepository implements LoginActivityRepositoryInterface
{
    /**
     * Get all login activities with filters.
     *
     * @param  array      $params
     * @return Collection
     */
    public function getAllActivities(array $params): Collection
    {
        return LoginActivity::query()
            ->with('user')
            ->when(isset($params['search']), static function ($query) use ($params): void {
                $query->whereHas('user', static function ($q) use ($params): void {
                    $q->where('name', 'like', '%' . $params['search'] . '%')
                        ->orWhere('email', 'like', '%' . $params['search'] . '%');
                });
            })
            ->get();
    }
}
