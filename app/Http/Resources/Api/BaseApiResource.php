<?php

declare(strict_types=1);

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

abstract class BaseApiResource extends JsonResource
{
    /**
     * Add common metadata to all responses.
     *
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'data' => parent::toArray($request),
            'meta' => $this->meta($request),
        ];
    }

    /**
     * Define the metadata structure.
     *
     * @param mixed $request
     */
    protected function meta($request): array
    {
        return [
            'timestamp' => now()->toIso8601String(),
            'api_version' => config('app.api_version', 'v1'),
            'environment' => app()->environment(),
            'execution_time' => $this->executionTime(),
            'authenticated' => $this->isAuthenticated(),
            'user_id' => $this->getUserId(),
        ];
    }

    /**
     * Calculate execution time (optional).
     */
    protected function executionTime(): float
    {
        return defined('LARAVEL_START') ? round((microtime(true) - LARAVEL_START) * 1000, 2) : 0.0;
    }

    /**
     * Check if the user is authenticated.
     */
    protected function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Get the ID of the currently authenticated user.
     */
    protected function getUserId(): int|string|null
    {
        return Auth::id();
    }
}
