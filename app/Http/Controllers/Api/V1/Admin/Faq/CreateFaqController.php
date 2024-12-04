<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Faq;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Http\Requests\Api\V1\Admin\Faq\CreateFaqRequest;
use App\Services\Faq\FaqService;
use Exception;
use Illuminate\Http\JsonResponse;

final class CreateFaqController extends BaseApiV1Controller
{
    public function __construct(
        private readonly FaqService $service,
    ) {}

    public function __invoke(CreateFaqRequest $request): JsonResponse
    {
        try {
            $faq = $this->service->create($request->validated());

            return $this->successResponse($faq, 'FAQ created successfully.');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to create FAQ', 500, ['exception' => $e->getMessage()]);
        }
    }
}
