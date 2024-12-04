<?php

// routes/api/routes.php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', fn (Request $request) => $request->user());

// Load Authentication Routes
Route::prefix('auth')->as('auth:')->group(function (): void {
    require base_path('routes/api/auth.php');
});

// Load Admin Routes
Route::prefix('admin')->as('admin:')->group(function (): void {
    require base_path('routes/api/v1/admin/dashboard.php');
    require base_path('routes/api/v1/admin/auth.php');
});
