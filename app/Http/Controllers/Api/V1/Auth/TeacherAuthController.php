<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Domain\Identity\Enums\UserType;
use Illuminate\Http\Request;

class TeacherAuthController extends BaseAuthController
{
    protected function getUserType(): string
    {
        return UserType::TEACHER->value;
    }

    protected function validateRegistration(Request $request): void
    {
        parent::validateRegistration($request);

        $request->validate([
            'bio' => 'required|string|max:1000',
            'expertise' => 'required|array|min:1',
            'expertise.*' => 'required|string|max:100',
        ]);
    }
} 