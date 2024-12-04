<?php

// routes\api\v1\admin\auth.php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->middleware('auth:sanctum')->name('admin.logout');
