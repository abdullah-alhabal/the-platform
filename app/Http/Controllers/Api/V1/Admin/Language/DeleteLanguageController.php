<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Language;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\Language\LanguageService;

final class DeleteLanguageController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LanguageService $service
    ) {}

    public function __invoke(int $id)
    {
        $this->service->deleteLanguage($id);

        return response()->json([
            'message' => 'Language deleted successfully.',
        ]);
    }
}
