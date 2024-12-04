<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\SocialMedia;

use App\Http\Requests\Api\V1\Admin\SocialMedia\StoreSocialMediaRequest;
use App\Services\SocialMedia\SocialMediaService;
use Illuminate\Http\JsonResponse;

final class StoreSocialMediaController
{
    /**
     * @param SocialMediaService $service
     */
    public function __construct(
        private readonly SocialMediaService $service
    ) {}

    public function __invoke(StoreSocialMediaRequest $request): JsonResponse
    {
        $this->service->create($request->validated());

        return response()->json(['message' => 'Social Media created successfully.'], 201);
    }
}
