<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Language;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\Language\LanguageService;

final class ListLanguagesController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LanguageService $service
    ) {}

    public function __invoke()
    {
        $languages = $this->service->getAllLanguages();

        return response()->json([
            'data' => $languages,
        ]);
    }
}
