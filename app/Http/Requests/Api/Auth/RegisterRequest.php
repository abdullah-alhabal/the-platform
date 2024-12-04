<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiFormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;

/**
 * RegisterRequest is a form request for handling user registration requests.
 * It extends the BaseApiFormRequest class and provides validation rules,
 * custom error messages, and attributes for the request.
 */
final class RegisterRequest extends BaseApiFormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
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
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
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
            'name' => 'full name',
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
