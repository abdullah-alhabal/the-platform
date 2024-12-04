<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Add proper authorization logic
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id|unique:teachers,user_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required|string|max:20',
            'bio' => 'required|string|max:1000',
            'avatar' => 'nullable|image|max:2048', // 2MB max
            'expertise' => 'required|array|min:1',
            'expertise.*' => 'required|string|max:100',
            'qualification' => 'required|array|min:1',
            'qualification.*' => 'required|string|max:100',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'expertise.required' => 'At least one area of expertise is required',
            'qualification.required' => 'At least one qualification is required',
            'avatar.max' => 'The avatar must not be larger than 2MB',
        ];
    }
} 