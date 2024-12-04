<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $version = 'v1'): Response
    {
        // Check if version is specified in the Accept header
        $acceptHeader = $request->header('Accept');
        if (preg_match('/application\/vnd\.api\+json;\s*version=(\d+)/', $acceptHeader, $matches)) {
            $version = 'v' . $matches[1];
        }

        // Check if version is specified in the URL
        if ($request->segment(2) === $version) {
            return $next($request);
        }

        // Check if version is supported
        if (!in_array($version, ['v1', 'v2'])) {
            return response()->json([
                'success' => false,
                'message' => 'API version not supported',
            ], 400);
        }

        // Add version to request attributes
        $request->attributes->add(['api_version' => $version]);

        return $next($request);
    }
} 