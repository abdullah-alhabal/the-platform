<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\VisitorMessage;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\VisitorMessage\VisitorMessageService;
use Illuminate\Http\JsonResponse;

final class DeleteMessageController extends BaseApiV1Controller
{
    public function __construct(
        private readonly VisitorMessageService $service
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        return response()->json(['success' => $this->service->deleteMessage($id)]);
    }
}
