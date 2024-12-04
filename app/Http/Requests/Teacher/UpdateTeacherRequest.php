<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Add proper authorization logic
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('teachers', 'email')->ignore($this->teacher->id),
            ],
            'phone' => 'sometimes|string|max:20',
            'bio' => 'sometimes|string|max:1000',
            'avatar' => 'nullable|image|max:2048',
            'expertise' => 'sometimes|array|min:1',
            'expertise.*' => 'required|string|max:100',
            'qualification' => 'sometimes|array|min:1',
            'qualification.*' => 'required|string|max:100',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'expertise.min' => 'At least one area of expertise is required',
            'qualification.min' => 'At least one qualification is required',
            'avatar.max' => 'The avatar must not be larger than 2MB',
        ];
    }
} 