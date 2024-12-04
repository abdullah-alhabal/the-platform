<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Language;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\Language\LanguageService;

final class ShowLanguageController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LanguageService $service
    ) {}

    public function __invoke(int $id)
    {
        $language = $this->service->getLanguageById($id);

        return response()->json([
            'data' => $language,
        ]);
    }
}
