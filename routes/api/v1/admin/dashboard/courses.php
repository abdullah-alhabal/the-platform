<?php

// routes/api/v1/admin/dashboard/courses.php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin\Course\{
    IndexCourseController,
    StoreCourseController,
    PublishCourseController
};
use Illuminate\Support\Facades\Route;

Route::prefix('courses')->group(function () {
    Route::get('/', IndexCourseController::class)->middleware('permission:view_courses');
    Route::post('/', StoreCourseController::class)->middleware('permission:create_courses');
    Route::patch('/{course}/publish', PublishCourseController::class)->middleware('permission:publish_courses');
});
