<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\PostComment;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\PostComment\PostCommentService;
use Illuminate\Http\JsonResponse;

final class ShowPostCommentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly PostCommentService $service
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        $comment = $this->service->find($id);

        return $comment
            ? response()->json(['data' => $comment])
            : response()->json(['message' => 'Comment not found'], 404);
    }
}
