<?php

use App\Http\Controllers\Api\V1\Teacher\DeleteTeacherController;
use App\Http\Controllers\Api\V1\Teacher\IndexTeacherController;
use App\Http\Controllers\Api\V1\Teacher\SearchTeacherByExpertiseController;
use App\Http\Controllers\Api\V1\Teacher\ShowTeacherController;
use App\Http\Controllers\Api\V1\Teacher\StoreTeacherController;
use App\Http\Controllers\Api\V1\Teacher\ToggleTeacherStatusController;
use App\Http\Controllers\Api\V1\Teacher\TopRatedTeacherController;
use App\Http\Controllers\Api\V1\Teacher\UpdateTeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // Teacher routes
        Route::prefix('teachers')->group(function () {
            Route::get('/', IndexTeacherController::class)
                ->middleware('permission:show_admins');
            Route::post('/', StoreTeacherController::class)
                ->middleware('permission:show_admins');
            Route::get('/top-rated', TopRatedTeacherController::class);
            Route::get('/search-expertise', SearchTeacherByExpertiseController::class);
            Route::get('/{teacher}', ShowTeacherController::class)
                ->middleware('permission:show_admins');
            Route::put('/{teacher}', UpdateTeacherController::class)
                ->middleware('permission:show_admins');
            Route::delete('/{teacher}', DeleteTeacherController::class)
                ->middleware('permission:show_admins');
            Route::patch('/{teacher}/toggle-status', ToggleTeacherStatusController::class)
                ->middleware('permission:show_admins');
        });

        // Other routes...
    });
});

// API v2 routes (for future use)
Route::prefix('v2')->group(function () {
    // Add v2 routes here when needed
}); 