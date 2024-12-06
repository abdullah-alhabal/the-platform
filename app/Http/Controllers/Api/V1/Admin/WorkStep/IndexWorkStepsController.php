<?php

declare(strict_types=1);


namespace App\Http\Controllers\Api\V1\Admin\WorkStep;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use App\Services\WorkStep\WorkStepService;
use Illuminate\Http\JsonResponse;

class IndexWorkStepsController extends BaseApiV1Controller
{
    public function __construct(
        private readonly WorkStepService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        try {

        }catch (Exception $e){

        }
    }
}
