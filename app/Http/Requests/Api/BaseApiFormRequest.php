<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * BaseApiFormRequest is an abstract class that extends the BaseFormRequest class.
 * It provides a foundation for API form requests with additional functionality for
 * handling validation failures in a way that is suitable for API responses.
 */
abstract class BaseApiFormRequest extends BaseFormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * This method is responsible for throwing an HttpResponseException with a JSON response
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
            ], Response::HTTP_UNPROCESSABLE_ENTITY),
        );
    }

    /**
     * Ensure the request is not rate limited.
     *
     * @throws ValidationException
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => RateLimiter::availableIn($this->throttleKey()),
                    'minutes' => ceil(RateLimiter::availableIn($this->throttleKey()) / 60),
                ]),
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
