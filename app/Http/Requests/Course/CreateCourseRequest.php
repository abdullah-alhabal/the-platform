<?php

namespace App\Http\Requests\Course;

use App\Domain\Course\DTOs\Course\CreateCourseDto;
use App\Domain\Course\Enums\CourseLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:courses,slug'],
            'description' => ['required', 'string'],
            'level' => ['required', new Enum(CourseLevel::class)],
            'teacher_id' => ['required', 'integer', 'exists:teachers,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'preview_video' => ['nullable', 'string', 'max:255'],
            'requirements' => ['nullable', 'array'],
            'requirements.*' => ['required', 'string'],
            'learning_outcomes' => ['nullable', 'array'],
            'learning_outcomes.*' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The course title is required.',
            'title.max' => 'The course title cannot exceed 255 characters.',
            'slug.required' => 'The course slug is required.',
            'slug.unique' => 'This course slug is already taken.',
            'description.required' => 'The course description is required.',
            'level.required' => 'The course level is required.',
            'teacher_id.required' => 'The teacher ID is required.',
            'teacher_id.exists' => 'The selected teacher does not exist.',
            'price.required' => 'The course price is required.',
            'price.min' => 'The course price must be at least 0.',
            'requirements.*.required' => 'Each requirement must be specified.',
            'learning_outcomes.*.required' => 'Each learning outcome must be specified.',
        ];
    }

    public function failedValidation($validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors(),
        ], 422));
    }

    public function toDto(): CreateCourseDto
    {
        return CreateCourseDto::fromArray($this->validated());
    }
} 