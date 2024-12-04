<?php

declare(strict_types=1);

namespace App\Enums\LoginActivity;

enum LoginActivityType: string
{
    case LOGIN = 'login';
    case LOGOUT = 'logout';
}
