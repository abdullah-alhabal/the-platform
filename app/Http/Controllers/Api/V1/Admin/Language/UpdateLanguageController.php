<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Language;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\Language\UpdateLanguageRequest;
use App\Services\Language\LanguageService;

final class UpdateLanguageController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LanguageService $service
    ) {}

    public function __invoke(UpdateLanguageRequest $request, int $id)
    {
        $updated = $this->service->updateLanguage($id, $request->validated());

        if ( ! $updated) {
            return response()->json(['message' => 'Language not found.'], 404);
        }

        return response()->json(['message' => 'Language updated successfully.']);
    }
}
