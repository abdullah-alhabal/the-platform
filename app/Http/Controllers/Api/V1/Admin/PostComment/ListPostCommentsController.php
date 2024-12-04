<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\PostComment\PostCommentService;
use Illuminate\Http\JsonResponse;

final class ListPostCommentsController extends BaseApiV1Controller
{
    public function __construct(
        private readonly PostCommentService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $comments = $this->service->listAll();

        return response()->json(['data' => $comments]);
    }
}
