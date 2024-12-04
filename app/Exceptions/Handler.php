<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

/**
 * Class Handler.
 *
 * Handles exceptions and provides custom error responses.
 */
final class Handler extends ExceptionHandler
{
    /**
     * @param Request $request
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if ($e instanceof NotFoundHttpException) {
            Log::error('NotFoundHttpException', [
                'url' => $request->url(),
                'method' => $request->method(),
                'timestamp' => now()->toIso8601String(),
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => 'Record not found.',
                'error_code' => 'NOT_FOUND_EXCEPTION',
                'timestamp' => now()->toIso8601String(),
            ], 404);
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Reportable exceptions
        $this->reportable(static function (Throwable $e): void {
            Log::error('Exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        });

        // Render-able exceptions
        $this->renderable(static function (UnauthorizedException $e, Request $request): JsonResponse {
            Log::warning('UnauthorizedException', [
                'url' => $request->url(),
                'method' => $request->method(),
                'timestamp' => now()->toIso8601String(),
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Unauthorized access',
            ], 403);
        });
    }
}
