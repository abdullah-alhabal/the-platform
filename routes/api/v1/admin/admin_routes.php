<?php

// routes/api/v1/admin/admin_routes.php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// Group all admin-related routes
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // Include dashboard-related routes
    require __DIR__ . '/dashboard/admin_dashboard_routes.php';
});
