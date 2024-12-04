<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * BaseFormRequest is an abstract class that extends the FormRequest class.
 * It provides a foundation for form requests with additional functionality for
 * handling validation and authorization failures.
 *
 * This class is designed to be extended by other form request classes to inherit
 * its functionality and ensure type safety and null safety.
 */
abstract class BaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method must be implemented by child classes to define the authorization logic.
     */
    abstract public function authorize(): bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * This method must be implemented by child classes to define the validation rules.
     */
    abstract public function rules(): array;

    /**
     * Add additional validation logic after the base validation.
     *
     * This method can be overridden by child classes to add custom validation logic.
     */
    abstract public function withValidator(Validator $validator): void;

    /**
     * Get custom messages for validator errors.
     *
     * This method can be overridden by child classes to provide custom error messages.
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * This method can be overridden by child classes to provide custom attributes for error messages.
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Handle a failed validation attempt.
     *
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'Validation failed.',
        ], 422));
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @throws AuthorizationException
     */
    protected function failedAuthorization(): void
    {
        throw new AuthorizationException('This action is unauthorized.');
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
