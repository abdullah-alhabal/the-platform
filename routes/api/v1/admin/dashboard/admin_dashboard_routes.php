<?php

// routes/api/v1/admin/dashboard/admin_dashboard_routes.php

declare(strict_types=1);

/**
 * This file defines the main entry point for all "dashboard" routes within the admin namespace.
 * 
 * Structure:
 * - Dashboard data (GET /api/v1/admin/dashboard)
 * - Nested routes for specific resources under the dashboard:
 *     - Courses management
 *     - Permissions management
 *     - Roles management
 *     - Teachers management
 *     - Users management
 * 
 * Notes for Future Developers:
 * - Each nested file (e.g., courses.php, permissions.php) should define routes related to its specific resource.
 * - Ensure route files are properly structured and only include resource-specific logic.
 * - Middleware applied here ensures only authenticated admin users have access.
 * - Follow the naming convention and structure to maintain consistency across route files.
 */

use Illuminate\Support\Facades\Route;

// Group dashboard-specific routes with shared middleware and prefix
Route::prefix('dashboard')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    
    // Main dashboard route (GET /api/v1/admin/dashboard)
    Route::get('/', DashboardController::class)->name('admin.dashboard');

    // Include additional dashboard resource routes
    require __DIR__ . '/courses.php';       // Routes for managing courses
    require __DIR__ . '/permissions.php';   // Routes for managing permissions
    require __DIR__ . '/roles.php';         // Routes for managing roles
    require __DIR__ . '/teachers.php';      // Routes for managing teachers
    require __DIR__ . '/users.php';         // Routes for managing users
});
