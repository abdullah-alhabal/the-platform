<?php

// routes/api/v1/admin/roles.php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin\Role;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin', 'role:super-admin'])->group(function (): void {
    Route::get('/roles', Role\ListRolesController::class)->name('roles.index');
    Route::post('/roles', Role\StoreRoleController::class)->name('roles.store');
    Route::get('/roles/{role}', Role\ShowRoleController::class)->name('roles.show');
    Route::put('/roles/{role}', Role\UpdateRoleController::class)->name('roles.update');
    Route::delete('/roles/{role}', Role\DeleteRoleController::class)->name('roles.destroy');
});
