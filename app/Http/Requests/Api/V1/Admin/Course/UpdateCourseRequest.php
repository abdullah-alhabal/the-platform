<?php

namespace App\Http\Requests\Api\V1\Admin\Course;

use App\Domain\Course\DTOs\Course\UpdateCourseDto;
use App\Domain\Course\Enums\CourseLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $course = $this->route('course');

        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'string', 'max:255', 'unique:courses,slug,' . $course->id],
            'description' => ['sometimes', 'string'],
            'level' => ['sometimes', new Enum(CourseLevel::class)],
            'price' => ['sometimes', 'numeric', 'min:0'],
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
            'title.max' => 'The course title cannot exceed 255 characters.',
            'slug.unique' => 'This course slug is already taken.',
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

    public function toDto(): UpdateCourseDto
    {
        return UpdateCourseDto::fromArray($this->validated());
    }
}
