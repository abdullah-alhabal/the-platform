<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\SocialMedia;

use App\Services\SocialMedia\SocialMediaService;
use Illuminate\Http\JsonResponse;

final class UpdateSocialMediaController
{
    private SocialMediaService $service;

    public function __construct(SocialMediaService $service)
    {
        $this->service = $service;
    }

    public function __invoke(UpdateSocialMediaRequest $request, int $id): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return response()->json(['message' => 'Social Media updated successfully.']);
    }
}
