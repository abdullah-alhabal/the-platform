<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

/**
 * Handles password reset link requests.
 */
final class PasswordResetLinkController extends BaseApiController
{
    /**
     * Sends a password reset link to the user.
     */
    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            // Send password reset link
            $status = Password::sendResetLink($request->only('email'));

            if (Password::RESET_LINK_SENT === $status) {
                return $this->successResponse(
                    data: [
                        'message' => 'Password reset link sent successfully.',
                    ],
                    message: 'Password reset link sent successfully.',
                    status: 200,
                );
            }

            return $this->errorResponse(
                message: 'Failed to send password reset link.',
                status: 400,
                errors: [
                    'error' => 'Failed to send password reset link.',
                ],
            );

        } catch (Exception $e) {
            return $this->errorResponse(
                message: 'An error occurred while sending the password reset link.',
                status: 500,
                errors: [
                    'error' => $e->getMessage(),
                ],
            );
        }
    }
}
