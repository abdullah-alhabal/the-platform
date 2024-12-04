<?php

// theProject\routes\api\auth.php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest:api'])->group(static function (): void {
    Route::post('login', Auth\LoginController::class)->name('api.login');
    Route::post('register', Auth\RegisteredUserController::class)->name('api.register');
    Route::post('forgot-password', Auth\PasswordResetLinkController::class)->name('api.password.email');
    Route::post('reset-password', Auth\NewPasswordController::class)->name('api.password.store');
});

Route::middleware(['auth:api', 'throttle:6,1'])->group(static function (): void {
    Route::post('email/verification-notification', Auth\EmailVerificationNotificationController::class)->name('api.verification.send');
    Route::post('logout', Auth\LogoutController::class)->name('api.logout');

    Route::middleware(['signed'])->group(static function (): void {
        Route::get('verify-email/{id}/{hash}', Auth\VerifyEmailController::class)->name('api.verification.verify');
    });
});
