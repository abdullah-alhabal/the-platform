<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Statistic;

use App\Services\Statistic\StatisticService;
use Illuminate\Http\JsonResponse;

final class ListStatisticController
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
