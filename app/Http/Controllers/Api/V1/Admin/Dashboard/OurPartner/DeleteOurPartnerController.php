<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Dashboard\OurPartner;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\OurPartner\OurPartnerService;
use Exception;
use Illuminate\Http\JsonResponse;

final class DeleteOurPartnerController extends BaseApiV1Controller
{
    public function __construct(
        private readonly OurPartnerService $service
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);

            return response()->json(['message' => __('delete_done')]);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('Failed to delete partner.'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
