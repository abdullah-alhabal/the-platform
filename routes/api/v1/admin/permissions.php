<?php

// routes/api/v1/admin/permissions.php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin\Permissions;
use Illuminate\Support\Facades\Route;

// Permission Management Routes (Super Admin Only)
Route::middleware(['auth:sanctum', 'role:admin', 'role:super-admin'])->group(function (): void {
    Route::get('/permissions', Permissions\ListPermissionsController::class)->name('permissions.index');
    Route::post('/permissions', Permissions\StorePermissionController::class)->name('permissions.store');
    Route::get('/permissions/{permission}', Permissions\ShowPermissionController::class)->name('permissions.show');
    Route::put('/permissions/{permission}', Permissions\UpdatePermissionController::class)->name('permissions.update');
    Route::delete('/permissions/{permission}', Permissions\DeletePermissionController::class)->name('permissions.destroy');
});
