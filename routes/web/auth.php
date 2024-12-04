<?php

declare(strict_types=1);

use App\Http\Controllers\Web\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Web\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Web\Auth\NewPasswordController;
use App\Http\Controllers\Web\Auth\PasswordResetLinkController;
use App\Http\Controllers\Web\Auth\RegisteredUserController;
use App\Http\Controllers\Web\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(static function (): void {
    Route::post('login', AuthenticatedSessionController::class)->name('login');
    Route::post('register', RegisteredUserController::class)->name('register');
    Route::post('forgot-password', PasswordResetLinkController::class)->name('password.email');
    Route::post('reset-password', NewPasswordController::class)->name('password.store');
});

Route::middleware(['auth', 'throttle:6,1'])->group(static function (): void {
    Route::post('email/verification-notification', EmailVerificationNotificationController::class)->name('verification.send');
    Route::post('logout', AuthenticatedSessionController::class)->name('logout');

    Route::middleware(['signed'])->group(static function (): void {
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->name('verification.verify');
    });
});
