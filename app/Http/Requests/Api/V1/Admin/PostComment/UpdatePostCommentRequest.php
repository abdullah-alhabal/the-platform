<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\PostComment;

use Illuminate\Foundation\Http\FormRequest;

final class UpdatePostCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update_post_comment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'text' => 'sometimes|required|string|max:500',
            'post_id' => 'sometimes|required|exists:posts,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'is_published' => 'sometimes|boolean',
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
            'is_published.boolean' => __('The published status must be true or false.'),
        ];
    }
}
