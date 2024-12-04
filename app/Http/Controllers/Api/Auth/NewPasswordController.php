<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

/**
 * Handles password reset requests.
 */
final class NewPasswordController extends BaseApiController
{
    /**
     * Reset the user's password.
     */
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        try {
            // Attempt to reset the password
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                static function ($user, $password): void {
                    $user->forceFill(['password' => bcrypt($password)])->save();
                },
            );

            // Check the status of the password reset
            if (Password::PASSWORD_RESET === $status) {
                return $this->successResponse(
                    data: [
                        'message' => 'Password reset successfully',
                    ],
                    message: 'Password reset successfully',
                    status: 200,
                );
            }

            return $this->errorResponse(
                message: 'Password reset failed',
                status: 400,
                errors: [
                    'error' => 'The provided token is invalid or expired.',
                ],
            );

        } catch (Exception $e) {
            return $this->errorResponse(
                message: 'An error occurred while resetting the password.',
                status: 500,
                errors: [
                    'error' => $e->getMessage(),
                ],
            );
        }
    }
}
