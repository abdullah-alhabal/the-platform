<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserLoggedOut;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

final class LogoutController extends BaseApiController
{
    /**
     * Handle the logout request by revoking the user's current access token.
     */
    public function __invoke(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if ( ! $user) {
            throw new Exception('Authenticated user not found.');
        }

        try {
            $user->currentAccessToken()->delete();

            Log::info('User logged out successfully.', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            event(new UserLoggedOut($user));

            return $this->successResponse(
                data: [
                    'message' => 'Login successful',
                    'user' => $user,
                ],
                message: 'Login successful',
                status: 200,
            );
        } catch (Exception $e) {
            Log::error('Login failed.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

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
