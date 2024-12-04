<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Auth;

use App\Http\Requests\Web\Auth\EmailVerificationNotificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

final class EmailVerificationNotificationController
{
    /**
     * Send a new email verification notification.
     */
    public function store(EmailVerificationNotificationRequest $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
