<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Auth;

use App\Http\Requests\Web\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class LoginController
{
    public function __invoke(LoginRequest $request): Response
    {
        $request->authenticate();

        $token = Auth::user()->createToken(
            name: $request->header('X-DEVICE-ID'),
        );

        return new JsonResponse(
            data: [
                'token' => $token->plainTextToken,
            ],
        );
    }
}
