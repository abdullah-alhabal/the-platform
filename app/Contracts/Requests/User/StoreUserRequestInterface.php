<?php

declare(strict_types=1);

namespace App\Contracts\Requests\User;

interface StoreUserRequestInterface
{
    /** * Determine if the user is authorized to make this request. * * @return bool */
    public function authorize(): bool;

    /** * Get the validation rules that apply to the request. * * @return array */
    public function rules(): array;

    /**
     * Get the validated data from the request.
     *
     * @param  array|int|string|null $key
     * @param  mixed                 $default
     * @return mixed
     */
    public function validated($key = null, $default = null);
}
