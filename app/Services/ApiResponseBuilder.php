<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\JsonResponse;

/**
 * ApiResponseBuilder is a utility class for building API responses in a standardized format.
 * It allows setting data, message, status, headers, and metadata for the response.
 * The build method constructs the response based on the set properties and returns a JsonResponse.
 */
final class ApiResponseBuilder
{
    /**
     * The data to be included in the response.
     */
    private array $data = [];

    /**
     * The message to be included in the response.
     */
    private ?string $message = null;

    /**
     * The HTTP status code for the response.
     */
    private int $status = 200;

    /**
     * The HTTP headers for the response.
     */
    private array $headers = ['Content-Type' => 'application/json'];

    /**
     * The metadata to be included in the response.
     */
    private array $meta = [];

    /**
     * Sets the data for the response.
     *
     * @param  array $data The data to be set.
     * @return self  This instance for method chaining.
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Sets the message for the response.
     *
     * @param  string $message The message to be set.
     * @return self   This instance for method chaining.
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Sets the HTTP status code for the response.
     *
     * @param  int  $status The status code to be set.
     * @return self This instance for method chaining.
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Sets or merges custom HTTP headers for the response.
     *
     * @param  array $headers The headers to be set or merged.
     * @return self  This instance for method chaining.
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * Adds metadata to the response.
     *
     * @param  array $meta The metadata to be added.
     * @return self  This instance for method chaining.
     */
    public function addMeta(array $meta): self
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }

    /**
     * Builds and returns the API response based on the set properties.
     *
     * @return JsonResponse The constructed API response.
     */
    public function build(): JsonResponse
    {
        $response = [
            'status' => $this->status < 400 ? 'success' : 'error',
            'message' => $this->message,
            'data' => $this->data,
            'meta' => $this->meta,
            'timestamp' => now()->toIso8601String(),
        ];

        return response()->json(array_filter($response), $this->status)->withHeaders($this->headers);
    }
}
