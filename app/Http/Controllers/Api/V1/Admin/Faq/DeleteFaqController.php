<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Faq;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\Faq\FaqService;
use Exception;
use Illuminate\Http\JsonResponse;

final class DeleteFaqController extends BaseApiV1Controller
{
    public function __construct(
        private readonly FaqService $faqService,
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->faqService->delete($id);

            return $this->successResponse([], 'FAQ deleted successfully.');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete FAQ', 500, ['exception' => $e->getMessage()]);
        }
    }
}
