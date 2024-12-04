<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\Settings;

use App\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;

final class StoreSettingRequest extends BaseApiV1FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'key' => [
                'required',
                'string',
                'unique:settings,key',
            ],
            'value' => [
                'nullable',
                'string',
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
