<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Faq;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\Faq\FaqService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ListFaqController extends BaseApiV1Controller
{
    public function __construct(
        private readonly FaqService $service,
        private readonly Application $application
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $locale = $this->application->getLocale();
            $faqs = $this->service->list($locale, $request->get('search'));

            return $this->successResponse($faqs);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to fetch FAQs', 500, ['exception' => $e->getMessage()]);
        }
    }
}
