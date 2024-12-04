<?php

declare(strict_types=1);

namespace App\Enums\User;

enum AddByType: string
{
    case ADMIN = 'admin';
    case EXCEL = 'excel';
}
