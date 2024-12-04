<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Services\Setting\SettingService;

final class DeleteSettingController extends Controller
{
    protected $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function __invoke(string $key)
    {
        $this->service->deleteSetting($key);

        return response()->json([
            'message' => 'Setting deleted successfully.',
        ]);
    }
}