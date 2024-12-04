<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\OurService;

use App\DataTransferObjects\OurService\CreateOurServiceDto;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\OurService\CreateOurServiceRequest;
use App\Services\OurService\OurServiceService;
use Exception;
use Illuminate\Http\JsonResponse;

final class CreateOurServiceController extends BaseApiV1Controller
{
    public function __construct(
        private readonly OurServiceService $service
    ) {}

    public function __invoke(CreateOurServiceRequest $request): JsonResponse
    {
        try {
            $dto = CreateOurServiceDto::fromRequest($request);
            $service = $this->service->create($dto);

            return response()->json([
                'success' => true,
                'data' => $service,
                'message' => 'Service created successfully',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create service',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }
}
