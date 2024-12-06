<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Domain\Identity\Enums\UserType;
use Illuminate\Http\Request;

class AdminAuthController extends BaseAuthController
{
    protected function getUserType(): string
    {
        return UserType::ADMIN->value;
    }

    protected function validateRegistration(Request $request): void
    {
        parent::validateRegistration($request);

        $request->validate([
            'department' => 'required|string|max:100',
            'position' => 'required|string|max:100',
        ]);
    }
} 