<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Users;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\Users\UpdateUserRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

final class UpdateUserController extends BaseApiV1Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function __invoke(UpdateUserRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $this->userService->update($id, $data);

        return response()->json(['message' => 'User updated successfully']);
    }
}
