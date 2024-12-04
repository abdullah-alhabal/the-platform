<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\Settings\UpdateSettingRequest;
use App\Services\Setting\SettingService;

final class UpdateSettingController extends Controller
{
    protected $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function __invoke(UpdateSettingRequest $request)
    {
        $this->service->saveSettings($request->validated());

        return response()->json([
            'message' => 'Settings updated successfully.',
        ]);
    }
}
