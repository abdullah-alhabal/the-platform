<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\LoginActivity;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\LoginActivity\LoginActivityResource;
use App\Services\LoginActivity\LoginActivityService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class LoginActivityController extends Controller
{
    private LoginActivityService $service;

    public function __construct(LoginActivityService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request to list login activities.
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $activities = $this->service->getAllActivities($request->all());

            return response()->json([
                'success' => true,
                'data' => LoginActivityResource::collection($activities),
            ]);
        } catch (Exception $e) {
            Log::error('Failed to fetch login activities', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch login activities: ' . $e->getMessage(),
            ], 500);
        }
    }
}
