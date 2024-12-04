<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Repositories\User\UserRepository;

final class AdminRepository extends UserRepository
{
    protected string $model = Admin::class;
    // Additional methods specific to Admin can be added here
}
