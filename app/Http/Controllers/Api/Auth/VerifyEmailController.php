<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use Exception;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

/**
 * Handles email verification requests.
 */
final class VerifyEmailController extends BaseApiController
{
    /**
     * Verify the user's email address.
     */
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        try {
            // Check if the user has already verified their email
            if ($request->user()->hasVerifiedEmail()) {
                return $this->successResponse(
                    data: [
                        'message' => 'Email already verified',
                    ],
                    message: 'Email already verified',
                    status: 200,
                );
            }

            // Mark the email as verified
            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }

            return $this->successResponse(
                data: [
                    'message' => 'Email verified successfully',
                ],
                message: 'Email verified successfully',
                status: 200,
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: 'An error occurred while verifying the email.',
                status: 500,
                errors: [
                    'error' => $e->getMessage(),
                ],
            );
        }
    }
}
