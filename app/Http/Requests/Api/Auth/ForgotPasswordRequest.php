<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiFormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;

/**
 * ForgotPasswordRequest is a form request for handling password reset requests.
 * It extends the BaseApiFormRequest class and provides validation rules,
 * custom error messages, and attributes for the request.
 */
final class ForgotPasswordRequest extends BaseApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool Returns true if the user is authorized, false otherwise.
     */
    public function authorize(): bool
    {
        return true; // Adjust this based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>> Returns an array of validation rules.
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'exists:users,email', // Ensure email exists in the users table
            ],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string> Returns an array of custom validation messages.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.exists' => 'The email address is not registered in our system.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string> Returns an array of custom attributes.
     */
    public function attributes(): array
    {
        return [
            'email' => 'email address',
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @throws AuthorizationException Throws an AuthorizationException.
     */
    public function failedAuthorization(): never
    {
        throw new AuthorizationException('You are not authorized to make this request.');
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator The validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        // Add custom validation logic here if needed
    }
}
