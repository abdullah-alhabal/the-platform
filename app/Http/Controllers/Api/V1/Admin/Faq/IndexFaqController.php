<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Faq;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\Faq\FaqService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class IndexFaqController extends BaseApiV1Controller
{
    public function __construct(
        private readonly FaqService $faqService,
        private readonly Application $application
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $locale = $this->application->getLocale();
            $faqs = $this->faqService->getAllFaqs($locale, $request->get('search'));

            return $this->successResponse($faqs);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to fetch FAQs', 500, ['exception' => $e->getMessage()]);
        }
    }
}
