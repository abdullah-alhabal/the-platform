<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\LoginActivity;

use Illuminate\Database\Eloquent\Collection;

interface LoginActivityRepositoryInterface
{
    /**
     * Get all login activities with filters.
     *
     * @param  array      $params
     * @return Collection
     */
    public function getAllActivities(array $params): Collection;
}
