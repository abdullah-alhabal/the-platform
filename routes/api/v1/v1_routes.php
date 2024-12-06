<?php

// routes/api/v1/v1_routes.php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// Load V1 routes
Route::prefix('v1')->group(function () {
    require __DIR__ . '/auth/api_auth_routes.php';
    require __DIR__ . '/admin/dashboard.php';
    require __DIR__ . '/admin/teachers.php';
    require __DIR__ . '/admin/courses.php';
    require __DIR__ . '/admin/roles.php';
    require __DIR__ . '/admin/permissions.php';
    require __DIR__ . '/teacher/courses.php';
});
