<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Dashboard\OurPartner;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\OurPartner\OurPartnerService;
use Exception;
use Illuminate\Http\JsonResponse;

final class IndexOurPartnerController extends BaseApiV1Controller
{
    public function __construct(
        private readonly OurPartnerService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        try {
            $partners = $this->service->listAll();

            return response()->json($partners);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('Failed to retrieve partners.'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
