<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\EmailVerificationNotificationRequest;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Handles email verification notification requests.
 */
final class EmailVerificationNotificationController extends BaseApiController
{
    /**
     * Sends a new email verification notification.
     */
    public function __invoke(EmailVerificationNotificationRequest $request): JsonResponse
    {
        try {
            if ($request->user()->hasVerifiedEmail()) {
                return $this->successResponse(
                    data: [
                        'message' => 'Email already verified',
                    ],
                    message: 'Email already verified',
                    status: 200,
                );
            }

            $request->user()->sendEmailVerificationNotification();

            return $this->successResponse(['message' => 'Verification link sent'], 'Verification link sent', 202);
        } catch (Exception $e) {
            return $this->errorResponse(
                message: 'An error occurred while sending the verification email.',
                status: 500,
                errors: [
                    'error' => $e->getMessage(),
                ],
            );
        }
    }
}
