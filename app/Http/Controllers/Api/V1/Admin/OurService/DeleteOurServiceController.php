<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\OurService;

use App\Http\Controllers\Controller;
use App\Services\OurService\OurServiceService;
use Exception;
use Illuminate\Http\JsonResponse;

final class DeleteOurServiceController extends Controller
{
    public function __construct(
        private readonly OurServiceService $service
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete service',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }
}
