<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Domain\Identity\Enums\UserType;
use Illuminate\Http\Request;

class StudentAuthController extends BaseAuthController
{
    protected function getUserType(): string
    {
        return UserType::STUDENT->value;
    }

    protected function validateRegistration(Request $request): void
    {
        parent::validateRegistration($request);

        $request->validate([
            'education_level' => 'nullable|string|max:100',
            'interests' => 'nullable|array',
            'interests.*' => 'required|string|max:100',
        ]);
    }
} 