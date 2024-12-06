<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Setting;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\Setting\SettingService;

final class IndexSettingController extends BaseApiV1Controller
{
    public function __construct(
        private readonly SettingService $service
    ){}

    public function __invoke()
    {
        return response()->json($this->service->listSettings());
    }
}
