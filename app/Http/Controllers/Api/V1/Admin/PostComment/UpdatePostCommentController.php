<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\PostComment;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\PostComment\UpdatePostCommentRequest;
use App\Services\PostComment\PostCommentService;
use Illuminate\Http\JsonResponse;

final class UpdatePostCommentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly PostCommentService $service
    ) {}

    public function __invoke(int $id, UpdatePostCommentRequest $request): JsonResponse
    {
        $updated = $this->service->update($id, $request->validated());

        return $updated
            ? response()->json(['message' => 'Updated successfully'])
            : response()->json(['message' => 'Update failed'], 500);
    }
}
