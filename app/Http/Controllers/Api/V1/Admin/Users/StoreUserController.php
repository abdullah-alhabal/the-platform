<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Users;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class StoreUserController extends BaseApiV1Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->all();
        $this->userService->store($data);

        return response()->json(['message' => 'User created successfully'], 201);
    }
}
