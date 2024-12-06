<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Domain\Identity\Enums\UserType;
use Illuminate\Http\Request;

class MarketerAuthController extends BaseAuthController
{
    protected function getUserType(): string
    {
        return UserType::MARKETER->value;
    }

    protected function validateRegistration(Request $request): void
    {
        parent::validateRegistration($request);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
        ]);
    }
} 