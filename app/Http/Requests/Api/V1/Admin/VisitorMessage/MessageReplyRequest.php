<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\VisitorMessage;

use Illuminate\Foundation\Http\FormRequest;

final class MessageReplyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => [
                'required',
                'string',
                'max:500',
            ],
        ];
    }
}
