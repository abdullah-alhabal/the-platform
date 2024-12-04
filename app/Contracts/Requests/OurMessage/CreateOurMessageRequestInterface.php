<?php

declare(strict_types=1);

namespace App\Contracts\Requests\OurMessage;

interface CreateOurMessageRequestInterface
{
    public function rules(): array;

    public function authorize(): bool;

    public function validated(array|int|string|null $key = null, mixed $default = null): mixed;
}