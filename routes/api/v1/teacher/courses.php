<?php

// routes/api/v1/teacher/courses.php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Teacher\Course\{
    IndexCourseController,
    StoreCourseController,
    UpdateCourseController,
    DeleteCourseController
};
use Illuminate\Support\Facades\Route;

Route::prefix('teacher/courses')->middleware(['auth:sanctum', 'role:teacher'])->group(function () {
    Route::get('/', IndexCourseController::class)->middleware('permission:view_courses');
    Route::post('/', StoreCourseController::class)->middleware('permission:create_courses');
    Route::put('/{course}', UpdateCourseController::class)->middleware('permission:edit_courses');
    Route::delete('/{course}', DeleteCourseController::class)->middleware('permission:delete_courses');
});
