<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\BaseApiFormRequest;
use Illuminate\Validation\ValidationException;

/**
 * Abstract BaseApiV1FormRequest class.
 *
 * This class serves as a base for all API V1 form requests, ensuring consistency and type safety across the application.
 *
 * @extends BaseApiFormRequest
 *
 * @method static BaseApiV1FormRequest createFromFactory()
 * @method static BaseApiV1FormRequest new()
 */
abstract class BaseApiV1FormRequest extends BaseApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        // Add your authentication logic here
    }
}
