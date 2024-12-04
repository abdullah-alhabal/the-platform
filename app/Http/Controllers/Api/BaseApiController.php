<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\ApiResponseBuilder;
use Illuminate\Http\JsonResponse;

/**
 * Base API controller for handling API requests and responses.
 *
 * This abstract class provides methods for building success and error responses
 * in a standardized format. It extends the BaseController to inherit common
 * controller functionality.
 */
abstract class BaseApiController extends BaseController
{
    /**
     * Builds and returns a successful API response.
     *
     * This method constructs a successful API response with the provided data,
     * optional message, status code, metadata, and headers. If no message is
     * provided, a default message is used.ListFaqController
     *
     * @param  array|object $data    The data to be included in the response.
     * @param  string|null  $message Optional message to be included in the response.
     * @param  int          $status  The HTTP status code for the response. Defaults to 200.
     * @param  array        $meta    Optional metadata to be included in the response.
     * @param  array        $headers Optional headers to be included in the response.
     * @return JsonResponse The constructed successful API response.
     */
    public function successResponse(
        array|object $data,
        ?string $message = null,
        int $status = 200,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return (new ApiResponseBuilder())
            ->setData($data)
            ->setMessage($message ?? 'Operation successful')
            ->setStatus($status)
            ->addMeta($meta)
            ->setHeaders($headers)
            ->build();
    }

    /**
     * Builds and returns an error API response.
     *
     * This method constructs an error API response with the provided message,
     * status code, errors, and headers. The errors are included in the response
     * data under the 'errors' key.
     *
     * @param  string       $message The error message to be included in the response.
     * @param  int          $status  The HTTP status code for the response. Defaults to 400.
     * @param  array        $errors  The errors to be included in the response data.
     * @param  array        $headers Optional headers to be included in the response.
     * @return JsonResponse The constructed error API response.
     */
    public function errorResponse(
        string $message,
        int $status = 400,
        array $errors = [],
        array $headers = [],
    ): JsonResponse {
        return (new ApiResponseBuilder())
            ->setData(['errors' => $errors])
            ->setMessage($message)
            ->setStatus($status)
            ->setHeaders($headers)
            ->build();
    }
}
