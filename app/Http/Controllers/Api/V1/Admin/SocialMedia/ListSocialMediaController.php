<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\SocialMedia;

use App\Services\SocialMedia\SocialMediaService;
use Illuminate\Http\JsonResponse;

final class ListSocialMediaController
{
    /**
     * @param SocialMediaService $service
     */
    public function __construct(
        private readonly SocialMediaService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        return response()->json($this->service->listAll());
    }
}
