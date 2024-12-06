<?php

// routes/web/routes.php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->as('auth:')->group(base_path(
    path: 'routes/api/auth.php',
));
