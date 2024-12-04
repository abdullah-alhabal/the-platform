<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Users;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

final class ShowUserController extends BaseApiV1Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        return response()->json($this->userService->findById($id));
    }
}