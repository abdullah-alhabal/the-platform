<?php

declare(strict_types=1);

namespace App\Services\LoginActivity;

use App\Repositories\LoginActivity\LoginActivityRepository;
use Illuminate\Database\Eloquent\Collection;

final class LoginActivityService
{
    private LoginActivityRepository $repository;

    public function __construct(LoginActivityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all login activities.
     *
     * @param  array      $params
     * @return Collection
     */
    public function getAllActivities(array $params): Collection
    {
        return $this->repository->getAllActivities($params);
    }
}
