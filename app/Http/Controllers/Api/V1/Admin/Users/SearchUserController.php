<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Users;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\Users\SearchUserRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

final class SearchUserController extends BaseApiV1Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function __invoke(SearchUserRequest $request, string $role): JsonResponse
    {
        return response()->json($this->userService->search($request->validated()));
    }
}
