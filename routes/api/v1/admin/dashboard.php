<?php

// routes\api\v1\admin\dashboard.php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin:')->middleware(['auth:sanctum', 'role:admin'])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware(['role:super-admin'])->group(function (): void {
        require base_path('routes/api/v1/admin/roles.php');
        require base_path('routes/api/v1/admin/permissions.php');
    });
});
