<?php

// routes/api/v1/teacher/teacher_routes.php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// Include course-related routes for teachers
Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
    require __DIR__ . '/courses.php';
});
