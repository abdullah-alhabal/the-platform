<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Language;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\Language\StoreLanguageRequest;
use App\Services\Language\LanguageService;

final class StoreLanguageController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LanguageService $service
    ) {}

    public function __invoke(StoreLanguageRequest $request)
    {
        $language = $this->service->createLanguage($request->validated());

        return response()->json([
            'message' => 'Language created successfully.',
            'data' => $language,
        ]);
    }
}
