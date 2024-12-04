<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Faq;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\Faq\UpdateFaqRequest;
use App\Services\Faq\FaqService;
use Exception;
use Illuminate\Http\JsonResponse;

final class UpdateFaqController extends BaseApiV1Controller
{
    public function __construct(
        private readonly FaqService $service,
    ) {}

    public function __invoke(int $id, UpdateFaqRequest $request): JsonResponse
    {
        try {
            $faq = $this->service->update($id, $request->validated());

            return $this->successResponse($faq, 'FAQ updated successfully.');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to update FAQ', 500, ['exception' => $e->getMessage()]);
        }
    }
}
