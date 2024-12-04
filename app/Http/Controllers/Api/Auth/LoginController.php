<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserLoggedIn;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\NewAccessToken;

/**
 * Class LoginController.
 *
 * Handles user login requests via the API.
 */
final class LoginController extends BaseApiController
{
    /**
     * Handle the login request.
     *
     * Authenticates the user using the provided credentials, generates a personal access token,
     * logs the login activity, and dispatches an event upon successful login.
     *
     * @param  LoginRequest $request The incoming login request containing credentials.
     * @return JsonResponse Returns a JSON response with the authentication token and user details.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $request->authenticate();

            /** @var User $user */
            $user = Auth::user();
            if ( ! $user instanceof User) {
                throw new Exception('Authenticated user not found.');
            }

            $deviceName = $request->header('X-DEVICE-ID') ?? 'Unknown Device';

            /** @var NewAccessToken $token */
            $token = $user->createToken($deviceName);

            Log::info('User logged in successfully.', [
                'user_id' => $user->id,
                'device_name' => $deviceName,
                'email' => $user->email,
            ]);

            event(new UserLoggedIn($user, $deviceName));

            return $this->successResponse(
                data: [
                    'message' => 'Login successful',
                    'token' => $token->plainTextToken,
                    'user' => $user,
                ],
                message: 'Login successful',
                status: 200,
            );
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error('Login failed.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return an error response
            return $this->errorResponse(
                message: 'An error occurred while logging in.',
                status: 500,
                errors: [
                    'error' => $e->getMessage(),
                ],
            );
        }
    }
}
