<?php

declare(strict_types=1);

namespace App\Repositories\Teacher;

use App\Models\Teacher;
use App\Repositories\User\UserRepository;

final class TeacherRepository extends UserRepository
{
    protected string $model = Teacher::class;
}
