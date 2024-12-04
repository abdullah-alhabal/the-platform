<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\Users;

use App\Contracts\Requests\User\StoreUserRequestInterface;
use App\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Illuminate\Contracts\Validation\Validator;

final class StoreUserRequest extends BaseApiV1FormRequest implements StoreUserRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|string>
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
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'role' => [
                'required',
                'string',
                'in:admin,user', // Adjust as per roles available
            ],
            'is_blocked' => [
                'nullable',
                'boolean',
            ],
            'is_validated' => [
                'nullable',
                'boolean',
            ],
            'is_accredited' => [
                'nullable',
                'boolean',
            ],
            'id_card_image' => [
                'nullable',
                'string',
                'max:2048',
            ],
            'employment_proof_image' => [
                'nullable',
                'string',
                'max:2048',
            ],
            'resume_file' => [
                'nullable',
                'string',
                'max:2048',
            ],
        ];
    }

    /**
     * Get custom error messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute field is required.',
            'name.string' => 'The :attribute must be a string.',
            'name.max' => 'The :attribute must not exceed :max characters.',
            'email.required' => 'The :attribute field is required.',
            'email.email' => 'The :attribute must be a valid email address.',
            'email.max' => 'The :attribute must not exceed :max characters.',
            'email.unique' => 'The :attribute has already been taken.',
            'password.required' => 'The :attribute field is required.',
            'password.string' => 'The :attribute must be a string.',
            'password.min' => 'The :attribute must be at least :min characters.',
            'password.confirmed' => 'The :attribute confirmation does not match.',
            'role.required' => 'The :attribute field is required.',
            'role.string' => 'The :attribute must be a string.',
            'role.in' => 'The :attribute must be one of the following: :values.',
            'is_blocked.boolean' => 'The :attribute field must be true or false.',
            'is_validated.boolean' => 'The :attribute field must be true or false.',
            'is_accredited.boolean' => 'The :attribute field must be true or false.',
            'id_card_image.max' => 'The :attribute must not exceed :max characters.',
            'employment_proof_image.max' => 'The :attribute must not exceed :max characters.',
            'resume_file.max' => 'The :attribute must not exceed :max characters.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'email address',
            'password' => 'password',
            'role' => 'role',
            'is_blocked' => 'blocked status',
            'is_validated' => 'validated status',
            'is_accredited' => 'accreditation status',
            'id_card_image' => 'ID card image',
            'employment_proof_image' => 'employment proof image',
            'resume_file' => 'resume file',
        ];
    }

    /**
     * Add additional validation logic after the base validation.
     *
     * This method can be overridden by child classes to add custom validation logic.
     */
    public function withValidator(Validator $validator): void
    {
        // TODO: Implement withValidator() method.
    }
}
