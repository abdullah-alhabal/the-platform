<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();
            $data = [
                'user_id' => $user->id,
                'ip' => $request->ip(),
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'status_code' => $response->status(),
            ];

            // Log the activity
            Log::channel('user_activity')->info('User Activity', $data);

            // Update last activity timestamp
            $user->update(['last_activity_at' => now()]);

            // Track login activity if it's a login request
            if ($request->is('api/auth/login') && $response->status() === 200) {
                $this->logLoginActivity($user, $request);
            }
        }

        return $response;
    }

    /**
     * Log user login activity.
     */
    protected function logLoginActivity($user, Request $request): void
    {
        $data = [
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'location' => $this->getLocationFromIp($request->ip()),
        ];

        // You can store this in a login_activities table
        // LoginActivity::create($data);

        Log::channel('login_activity')->info('User Login', $data);
    }

    /**
     * Get location information from IP address.
     */
    protected function getLocationFromIp(string $ip): ?array
    {
        // Implement IP geolocation using a service like MaxMind GeoIP2
        // For now, return null
        return null;
    }
} 