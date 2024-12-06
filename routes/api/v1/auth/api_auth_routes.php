<?php

// routes/api/v1/auth/api_auth_routes.php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Auth\AdminAuthController;
use App\Http\Controllers\Api\V1\Auth\MarketerAuthController;
use App\Http\Controllers\Api\V1\Auth\StudentAuthController;
use App\Http\Controllers\Api\V1\Auth\TeacherAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    // Admin Auth
    Route::prefix('admin')->group(function () {
        Route::post('login', [AdminAuthController::class, 'login']);
        Route::post('register', [AdminAuthController::class, 'register'])->middleware('permission:create_admins');
        Route::post('verify-email', [AdminAuthController::class, 'verifyEmail']);
        Route::post('verify-phone', [AdminAuthController::class, 'verifyPhone']);
        Route::post('resend-verification', [AdminAuthController::class, 'resendVerification'])->middleware('auth:sanctum');
        Route::post('logout', [AdminAuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    // Teacher Auth
    Route::prefix('teacher')->group(function () {
        Route::post('login', [TeacherAuthController::class, 'login']);
        Route::post('register', [TeacherAuthController::class, 'register']);
        Route::post('verify-email', [TeacherAuthController::class, 'verifyEmail']);
        Route::post('verify-phone', [TeacherAuthController::class, 'verifyPhone']);
        Route::post('resend-verification', [TeacherAuthController::class, 'resendVerification'])->middleware('auth:sanctum');
        Route::post('logout', [TeacherAuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    // Student Auth
    Route::prefix('student')->group(function () {
        Route::post('login', [StudentAuthController::class, 'login']);
        Route::post('register', [StudentAuthController::class, 'register']);
        Route::post('verify-email', [StudentAuthController::class, 'verifyEmail']);
        Route::post('verify-phone', [StudentAuthController::class, 'verifyPhone']);
        Route::post('resend-verification', [StudentAuthController::class, 'resendVerification'])->middleware('auth:sanctum');
        Route::post('logout', [StudentAuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    // Marketer Auth
    Route::prefix('marketer')->group(function () {
        Route::post('login', [MarketerAuthController::class, 'login']);
        Route::post('register', [MarketerAuthController::class, 'register']);
        Route::post('verify-email', [MarketerAuthController::class, 'verifyEmail']);
        Route::post('verify-phone', [MarketerAuthController::class, 'verifyPhone']);
        Route::post('resend-verification', [MarketerAuthController::class, 'resendVerification'])->middleware('auth:sanctum');
        Route::post('logout', [MarketerAuthController::class, 'logout'])->middleware('auth:sanctum');
    });
});
