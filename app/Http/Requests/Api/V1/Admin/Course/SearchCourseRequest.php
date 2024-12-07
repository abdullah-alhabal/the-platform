<?php

namespace App\Http\Requests\Api\V1\Admin\Course;

use Illuminate\Foundation\Http\FormRequest;

class SearchCourseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'query' => 'required|string|min:3',
            'filters' => 'nullable|array',
            'filters.level' => 'nullable|string',
            'filters.price_min' => 'nullable|numeric|min:0',
            'filters.price_max' => 'nullable|numeric|gt:filters.price_min',
            'filters.teacher_id' => 'nullable|integer|exists:teachers,id',
            'filters.is_published' => 'nullable|boolean',
        ];
    }

    public function getQuery(): string
    {
        return $this->validated('query');
    }

    public function getFilters(): array
    {
        return $this->validated('filters') ?? [];
    }
}
