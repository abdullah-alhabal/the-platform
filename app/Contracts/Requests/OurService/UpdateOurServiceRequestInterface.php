<?php

declare(strict_types=1);

namespace App\Contracts\Requests\OurService;

interface UpdateOurServiceRequestInterface
{
    public function rules(): array;

    public function authorize(): bool;

    /**
     * Get the validated data from the request.
     *
     * @param  array|int|string|null $key
     * @param  mixed                 $default
     * @return mixed
     */
    public function validated(array|int|string|null $key = null, mixed $default = null): mixed;
}
