<?php

namespace App\Http\Requests\Api\V1\Admin\Course;

use App\Domain\Course\DTOs\GetAllCoursesFilterDto;
use Illuminate\Foundation\Http\FormRequest;

class GetAllCoursesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'level' => 'nullable|string',
            'teacher_id' => 'nullable|integer|exists:teachers,id',
            'is_published' => 'nullable|boolean',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|gt:price_min',
        ];
    }

    public function toDto(): GetAllCoursesFilterDto
    {
        return GetAllCoursesFilterDto::fromArray($this->validated());
    }
}
