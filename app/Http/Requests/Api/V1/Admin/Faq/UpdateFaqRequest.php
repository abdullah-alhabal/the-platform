<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\Faq;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateFaqRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|string|max:255',
            'order' => 'required|integer',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.text' => 'required|string',
        ];
    }
}
