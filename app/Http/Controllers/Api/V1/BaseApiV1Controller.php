<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class BaseApiV1Controller extends Controller
{
    use AuthorizesRequests;

    protected function successResponse($data = null, string $message = 'Success', int $statusCode = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function errorResponse(string $message = 'Error', int $statusCode = 400): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }

    protected function createdResponse($data = null, string $message = 'Created successfully'): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    protected function noContentResponse(): \Illuminate\Http\JsonResponse
    {
        return response()->json(null, 204);
    }

    protected function respondCreated(array $data): JsonResponse
    {
        return response()->json($data, 201);
    }

    protected function respondOk(array $data): JsonResponse
    {
        return response()->json($data, 200);
    }

    protected function respondNoContent(): JsonResponse
    {
        return response()->json(null, 204);
    }

    protected function respondError(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json(['error' => $message], $statusCode);
    }

    protected function respondNotFound(string $message = 'Resource not found'): JsonResponse
    {
        return $this->respondError($message, 404);
    }

    protected function respondUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->respondError($message, 401);
    }

    protected function respondForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->respondError($message, 403);
    }

    protected function respondValidationError(array $errors): JsonResponse
    {
        return response()->json(['errors' => $errors], 422);
    }
}
