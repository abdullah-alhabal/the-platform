<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\Language;

use App\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Illuminate\Contracts\Validation\Validator;

final class StoreLanguageRequest extends BaseApiV1FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'lang' => [
                'required',
                'string',
                'max:50',
                'unique:languages,lang',
            ],
            'is_default' => [
                'required',
                'boolean',
            ],
            'is_rtl' => [
                'required',
                'boolean',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
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
