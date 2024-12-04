<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

final class ApiMonitoringException extends Exception
{
    /**
     * Report the exception for monitoring.
     */
    public function report(): void
    {
        // Log the exception for monitoring
        Log::error('API Monitoring Exception', [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => $this->getTraceAsString(),
        ]);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => true,
            'message' => $this->getMessage() ?: 'An unexpected error occurred.',
            'code' => $this->getCode() ?: 500,
        ], $this->getCode() ?: 500);
    }
}
