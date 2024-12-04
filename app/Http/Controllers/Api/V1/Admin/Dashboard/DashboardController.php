<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Dashboard;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\Dashboard\DashboardRequest;

final class DashboardController extends BaseApiV1Controller
{
    public function __invoke(DashboardRequest $request)
    {
        return $this->successResponse(
            data: [
                'message' => 'Welcome to the admin dashboard.',
            ],
            message: 'Welcome to the admin dashboard',
            status: 200,
        );
    }
}
