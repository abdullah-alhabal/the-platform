<?php

/**
 * BaseController is an abstract class that extends the Illuminate Controller.
 * It includes traits for authorizing requests and dispatching jobs.
 *
 * @extends \Illuminate\Routing\Controller
 *
 * @uses \Illuminate\Foundation\Auth\Access\AuthorizesRequests
 * @uses \Illuminate\Foundation\Bus\DispatchesJobs
 */
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * BaseController is an abstract class that extends the Illuminate Controller.
 * It includes traits for authorizing requests and dispatching jobs.
 *
 * @property-read \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model[] $models
 */
abstract class BaseController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
}
