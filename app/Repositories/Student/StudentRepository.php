<?php

declare(strict_types=1);

namespace App\Repositories\Student;

use App\Models\Student;
use App\Repositories\User\UserRepository;

final class StudentRepository extends UserRepository
{
    protected string $model = Student::class;
}
