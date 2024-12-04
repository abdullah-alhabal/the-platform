<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\SocialMedia;

use App\Services\SocialMedia\SocialMediaService;
use Illuminate\Http\JsonResponse;

final class DeleteSocialMediaController
{
    /**
     * @param SocialMediaService $service
     */
    public function __construct(
        private readonly SocialMediaService $service
    ) {}

    /**
     * @param  int          $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json(['message' => 'Social Media deleted successfully.']);
    }
}
