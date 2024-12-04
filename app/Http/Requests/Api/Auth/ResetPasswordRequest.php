<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiFormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Handles validation for password reset requests.
 * This class extends BaseApiFormRequest and provides validation rules,
 * custom error messages, and attributes for the request.
 */
final class ResetPasswordRequest extends BaseApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to make the request.
     *
     * @return bool Returns true if the user is authorized, false otherwise.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to attempt password resets.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method returns an array of validation rules for the request.
     *
     * @return array<int, array<int, string>> Returns an array of validation rules.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
            'token' => ['required', 'string'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * This method returns an array of custom validation messages.
     *
     * @return array<string, string> Returns an array of custom validation messages.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.exists' => 'We could not find a user with that email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password_confirmation.required' => 'The password confirmation field is required.',
            'token.required' => 'The token field is required.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * This method returns an array of custom attributes for error messages.
     *
     * @return array<string, string> Returns an array of custom attributes.
     */
    public function attributes(): array
    {
        return [
            'email' => 'email address',
            'password' => 'new password',
            'password_confirmation' => 'password confirmation',
            'token' => 'reset token',
        ];
    }

    /**
     * Add additional validation logic after the base validation.
     *
     * This method can be used to add custom validation logic.
     *
     * @param Validator $validator The validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        // Additional custom validation logic can go here if needed.
    }

    /**
     * Handle a failed validation attempt.
     *
     * This method throws an HttpResponseException when validation fails.
     *
     * @throws HttpResponseException Throws an HttpResponseException.
     */
    protected function failedValidation(Validator $validator): never
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422),
        );
    }

    /**
     * Handle a failed authorization attempt.
     *
     * This method throws an AuthorizationException when authorization fails.
     *
     * @throws AuthorizationException Throws an AuthorizationException.
     */
    protected function failedAuthorization(): never
    {
        throw new AuthorizationException('You are not authorized to make this request.');
    }
}
