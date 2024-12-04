<?php

declare(strict_types=1);

namespace App\Http\Requests\Web;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * BaseWebFormRequest is an abstract class that extends the BaseFormRequest class.
 * It provides a foundation for web form requests with additional functionality for
 * handling validation failures in a way that is suitable for web responses.
 */
abstract class BaseWebFormRequest extends BaseFormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * This method is responsible for throwing an HttpResponseException with a response
     * containing the validation errors when the validation of the request fails.
     *
     * @param Validator $validator The validator instance.
     *
     * @throws HttpResponseException The exception to be thrown when validation fails.
     */
    protected function failedValidation(Validator $validator): never
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422),
        );
    }
}
