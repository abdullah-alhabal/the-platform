<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Handles authenticated session management for API requests.
 */
final class AuthenticatedSessionController extends BaseApiController
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');

            if ( ! Auth::attempt($credentials)) {
                return $this->errorResponse('Invalid credentials', 401);
            }

            /** @var User */
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse(['message' => 'Login successful', 'token' => $token], 'Login successful', 200);
        } catch (Exception $e) {
            return $this->errorResponse(
                message: 'An error occurred while logging in.',
                status: 500,
                errors: [
                    'error' => $e->getMessage(),
                ],
            );
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();

            return $this->successResponse(['message' => 'Logout successful'], 'Logout successful', 200);
        } catch (Exception $e) {
            return $this->errorResponse(
                message: 'An error occurred while logging out.',
                status: 500,
                errors: [
                    'error' => $e->getMessage(),
                ],
            );
        }
    }
}
