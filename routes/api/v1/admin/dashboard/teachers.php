<?php

// routes/api/v1/admin/dashboard/teachers.php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin\Teachers\{
    IndexTeacherController,
    StoreTeacherController,
    TopRatedTeacherController,
    SearchTeacherByExpertiseController,
    ShowTeacherController,
    UpdateTeacherController,
    DeleteTeacherController,
    ToggleTeacherStatusController
};
use Illuminate\Support\Facades\Route;

Route::prefix('teachers')->group(function () {
    Route::get('/', IndexTeacherController::class)->middleware('permission:view_teachers');
    Route::post('/', StoreTeacherController::class)->middleware('permission:create_teachers');
    Route::get('/top-rated', TopRatedTeacherController::class)->middleware('permission:view_teachers');
    Route::get('/search', SearchTeacherByExpertiseController::class)->middleware('permission:view_teachers');
    Route::get('/{teacher}', ShowTeacherController::class)->middleware('permission:view_teachers');
    Route::put('/{teacher}', UpdateTeacherController::class)->middleware('permission:edit_teachers');
    Route::delete('/{teacher}', DeleteTeacherController::class)->middleware('permission:delete_teachers');
    Route::patch('/{teacher}/toggle-status', ToggleTeacherStatusController::class)->middleware('permission:edit_teachers');
});
