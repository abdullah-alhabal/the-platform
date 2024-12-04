<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\OurService;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\OurService\OurServiceService;
use Exception;
use Illuminate\Http\JsonResponse;

final class ListOurServiceController extends BaseApiV1Controller
{
    public function __construct(
        private readonly OurServiceService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        try {
            $services = $this->service->getAllServices();

            return response()->json([
                'success' => true,
                'data' => $services,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch services',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }
}
