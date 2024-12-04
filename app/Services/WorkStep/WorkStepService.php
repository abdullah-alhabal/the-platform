<?php

namespace App\Services\WorkStep;

use App\Contracts\Repositories\WorkStep\WorkStepRepositoryInterface;

class WorkStepService {

    public function __construct(
      private readonly WorkStepRepositoryInterface $repository
    ) {}
}
