<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Statistic;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\Statistic\StatisticService;
use Illuminate\Http\JsonResponse;

final class IndexStatisticController extends BaseApiV1Controller
{
    /**
     * @param StatisticService $statisticService
     */
    public function __construct(
        private readonly StatisticService $statisticService
    ) {}

    public function __invoke(): JsonResponse
    {
        return response()->json($this->statisticService->getAllStatistics());
    }
}
