<?php

declare(strict_types=1);

namespace App\Http\Requests\Web\Auth;

use App\Http\Requests\Web\BaseWebFormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;

/**
 * LoginRequest is a form request for handling login requests.
 * It extends the BaseWebFormRequest class and provides validation rules,
 * custom error messages, and attributes for the request.
 */
final class LoginRequest extends BaseWebFormRequest
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
        return true; // Adjust this based on your authorization logic
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
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
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
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
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
            'password' => 'password',
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * This method throws an AuthorizationException when authorization fails.
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
     * This method can be used to add custom validation logic.
     *
     * @param Validator $validator The validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        // Add custom validation logic here if needed
    }
}
