<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Dashboard\OurPartner;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\OurPartner\StoreOurPartnerRequest;
use App\Services\OurPartner\OurPartnerService;
use Exception;
use Illuminate\Http\JsonResponse;

final class StoreOurPartnerController extends BaseApiV1Controller
{
    public function __construct(
        private readonly OurPartnerService $service
    ) {}

    public function __invoke(StoreOurPartnerRequest $request): JsonResponse
    {
        try {
            $partner = $this->service->create($request->validated());

            return response()->json($partner, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('Failed to create partner.'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
