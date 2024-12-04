<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\VisitorMessage\VisitorMessageService;
use Illuminate\Http\JsonResponse;

final class ListMessagesController extends BaseApiV1Controller
{
    public function __construct(
        private readonly VisitorMessageService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        return response()->json($this->service->getAllMessages());
    }
}
