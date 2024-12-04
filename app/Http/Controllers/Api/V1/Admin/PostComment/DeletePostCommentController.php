<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\PostComment;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\PostComment\PostCommentService;
use Illuminate\Http\JsonResponse;

final class DeletePostCommentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly PostCommentService $service
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        $deleted = $this->service->delete($id);

        return $deleted
            ? response()->json(['message' => 'Deleted successfully'])
            : response()->json(['message' => 'Delete failed'], 500);
    }
}
