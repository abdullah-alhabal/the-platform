<?php

declare(strict_types=1);

namespace App\Contracts\Requests\User;

interface UpdateUserRequestInterface
{
    /** * Determine if the user is authorized to make this request. * * @return bool */
    public function authorize(): bool;

    /** * Get the validation rules that apply to the request. * * @return array */
    public function rules(): array;
}
