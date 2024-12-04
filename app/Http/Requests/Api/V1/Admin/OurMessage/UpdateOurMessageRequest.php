<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\OurMessage;

use App\Contracts\Requests\OurMessage\UpdateOurMessageRequestInterface;
use App\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Illuminate\Contracts\Validation\Validator;

final class UpdateOurMessageRequest extends BaseApiV1FormRequest implements UpdateOurMessageRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => 'sometimes|image|max:2048',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @param  array|int|string|null $key
     * @param  mixed                 $default
     * @return mixed
     */
    public function validated(array|int|string|null $key = null, mixed $default = null): mixed
    {
        return parent::validated($key, $default);
    }

    /**
     * Add additional validation logic after the base validation.
     *
     * This method can be overridden by child classes to add custom validation logic.
     */
    public function withValidator(Validator $validator): void
    {
        // Implement withValidator() method if needed.
    }
}
