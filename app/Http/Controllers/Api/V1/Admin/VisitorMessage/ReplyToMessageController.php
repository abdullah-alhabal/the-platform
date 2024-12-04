<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\VisitorMessage;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\VisitorMessage\MessageReplyRequest;
use App\Services\VisitorMessage\VisitorMessageService;
use Illuminate\Http\JsonResponse;

final class ReplyToMessageController extends BaseApiV1Controller
{
    public function __construct(
        private readonly VisitorMessageService $service
    ) {}

    public function __invoke(int $id, MessageReplyRequest $request): JsonResponse
    {
        $success = $this->service->sendReply($id, $request->content);

        return response()->json(['success' => $success]);
    }
}
