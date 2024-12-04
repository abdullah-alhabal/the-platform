<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

/**
 * Handles user registration requests.
 */
final class RegisteredUserController extends BaseApiController
{
    /**
     * Registers a new user.
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {
            /** @var User $user */
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            event(new UserRegistered($user));

            return $this->successResponse(
                data: [
                    'message' => 'Registration successful',
                    'token' => $token,
                ],
                message: 'Registration successful',
                status: 201,
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: 'An error occurred while registering the user.',
                status: 500,
                errors: [
                    'error' => $e->getMessage(),
                ],
            );
        }
    }
}
