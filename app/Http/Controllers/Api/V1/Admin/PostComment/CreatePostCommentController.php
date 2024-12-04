<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\PostComment;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\PostComment\StorePostCommentRequest;
use App\Services\PostComment\PostCommentService;
use Illuminate\Http\JsonResponse;

final class CreatePostCommentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly PostCommentService $service
    ) {}

    public function __invoke(StorePostCommentRequest $request): JsonResponse
    {
        $comment = $this->service->create($request->validated());

        return response()->json(['data' => $comment], 201);
    }
}
