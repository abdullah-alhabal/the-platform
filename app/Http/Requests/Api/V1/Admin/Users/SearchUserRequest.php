<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\Users;

use App\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Illuminate\Contracts\Validation\Validator;

final class SearchUserRequest extends BaseApiV1FormRequest
{
    /**
     * {@inheritDoc}
     */
    public function withValidator(Validator $validator): void
    {
        // TODO: Implement withValidator() method.
    }
}
