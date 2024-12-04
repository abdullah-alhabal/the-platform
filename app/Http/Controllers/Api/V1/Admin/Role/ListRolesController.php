<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Role;

use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\Request;

final class ListRolesController extends BaseApiV1Controller
{
    public function __invoke(Request $request): void {}
}
