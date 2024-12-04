<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\Role;

use App\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;

final class StoreRoleRequest extends BaseApiV1FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:250',
                'unique:roles,name',
            ],
            'permissions' => [
                'required',
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    public function withValidator(Validator $validator): void {}

    public function failedAuthorization(): never
    {
        throw new AuthorizationException('You are not authorized to make this request.');
    }
}
