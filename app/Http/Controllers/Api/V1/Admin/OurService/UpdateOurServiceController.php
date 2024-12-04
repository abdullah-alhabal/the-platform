<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\OurService;

use App\DataTransferObjects\OurService\UpdateOurServiceDto;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\OurService\UpdateOurServiceRequest;
use App\Services\OurService\OurServiceService;
use Exception;
use Illuminate\Http\JsonResponse;

final class UpdateOurServiceController extends BaseApiV1Controller
{
    public function __construct(
        private readonly OurServiceService $service
    ) {}

    public function __invoke(UpdateOurServiceRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdateOurServiceDto::fromRequest($request);
            $updated = $this->service->update($id, $dto);

            return response()->json([
                'success' => true,
                'data' => $updated,
                'message' => 'Service updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }
}
