<?php

namespace App\Http\Middleware;

use App\Domain\Course\Enums\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!$request->user() || !$request->user()->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Missing permission: ' . $permission,
                ], 403);
            }

            abort(403, 'Unauthorized. Missing permission: ' . $permission);
        }

        return $next($request);
    }
} 