<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\SocialMedia;

use App\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Illuminate\Contracts\Validation\Validator;

final class StoreSocialMediaRequest extends BaseApiV1FormRequest
{
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
