<?php

declare(strict_types=1);

namespace App\Enums\User;

enum UserType: string
{
    case STUDENT = 'student';
    case LECTURER = 'lecturer';
    case MARKETER = 'marketer';
}
