<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\PostComment;

use Illuminate\Foundation\Http\FormRequest;

final class StorePostCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create_post_comment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'text' => 'required|string|max:500',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'text.required' => __('The text field is required.'),
            'text.max' => __('The text field must not exceed 500 characters.'),
            'post_id.required' => __('A valid post ID is required.'),
            'post_id.exists' => __('The specified post does not exist.'),
            'user_id.required' => __('A valid user ID is required.'),
            'user_id.exists' => __('The specified user does not exist.'),
        ];
    }
}
