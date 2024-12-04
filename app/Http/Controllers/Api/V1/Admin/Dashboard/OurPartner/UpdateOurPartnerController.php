<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Dashboard\OurPartner;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\OurPartner\UpdateOurPartnerRequest;
use App\Services\OurPartner\OurPartnerService;
use Exception;
use Illuminate\Http\JsonResponse;

final class UpdateOurPartnerController extends BaseApiV1Controller
{
    public function __construct(
        private readonly OurPartnerService $service
    ) {}

    public function __invoke(int $id, UpdateOurPartnerRequest $request): JsonResponse
    {
        try {
            $this->service->update($id, $request->validated());

            return response()->json(['message' => __('message_done')]);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('Failed to update partner.'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
