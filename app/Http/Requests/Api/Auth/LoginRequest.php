<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiFormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * LoginRequest is a form request for handling login requests.
 * It extends the BaseApiFormRequest class and provides validation rules,
 * custom error messages, and attributes for the request. Additionally, it includes
 * an authenticate method to validate credentials without starting a session.
 */
final class LoginRequest extends BaseApiFormRequest
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
        return true; // Allow any user to attempt login
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
                'exists:users,email',
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
            'email.exists' => 'The email does not exist.',
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

    /**
     * Authenticate the user without starting a session.
     *
     * This method validates the credentials provided in the request without
     * starting a session.
     *
     * @throws ValidationException Throws a ValidationException if authentication fails.
     */
    public function authenticate(): void
    {
        $credentials = $this->only('email', 'password');

        // Attempt login without maintaining a session
        if ( ! Auth::attempt($credentials, false)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    }
}
