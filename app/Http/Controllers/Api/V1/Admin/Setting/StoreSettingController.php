<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Setting;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\Settings\StoreSettingRequest;
use App\Services\Setting\SettingService;

final class StoreSettingController extends BaseApiV1Controller
{
    public function __construct(
        private readonly SettingService $service
    ) {}

    public function __invoke(StoreSettingRequest $request)
    {
        $this->service->saveSettings($request->validated());

        return response()->json([
            'message' => 'Settings saved successfully.',
        ]);
    }
}
