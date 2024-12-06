<?php

declare(strict_types=1);

use App\Exceptions\ApiMonitoringException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Lottery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web/web_routes.php',
        api: __DIR__ . '/../routes/api/api_routes.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(
        callback: static function (Middleware $middleware): void {
            $middleware->use([
                Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,
                Illuminate\Http\Middleware\TrustProxies::class,
                Illuminate\Http\Middleware\HandleCors::class,
                Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
                Illuminate\Http\Middleware\ValidatePostSize::class,
                Illuminate\Foundation\Http\Middleware\TrimStrings::class,
                Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            ]);

            $middleware->web([
                Illuminate\Cookie\Middleware\EncryptCookies::class,
                Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                Illuminate\Session\Middleware\StartSession::class,
                Illuminate\View\Middleware\ShareErrorsFromSession::class,
                Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
                Illuminate\Routing\Middleware\SubstituteBindings::class,
            ]);

            $middleware->api(prepend: [
                'throttle:api',
                App\Http\Middleware\DeviceIdentifier::class,
                Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
                Illuminate\Routing\Middleware\SubstituteBindings::class,
            ]);

            $middleware->validateCsrfTokens(except: [
                '/api/*',
            ]);
        },
    )
    ->withExceptions(
        using: static function (Exceptions $exceptions): void {
            // Custom exception renderers
            $exceptions->render(static function (InvalidSignatureException $e, $request) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid verification link.',
                        'error_code' => 'INVALID_SIGNATURE',
                        'timestamp' => now()->toIso8601String(),
                    ], 400);
                }
            });

            $exceptions->render(static function (NotFoundHttpException $e, $request) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Resource not found.',
                        'error_code' => 'NOT_FOUND',
                        'timestamp' => now()->toIso8601String(),
                    ], 404);
                }
            });

            // Global exception throttling
            $exceptions->throttle(static fn () => Lottery::odds(1, 1000));

            // Add the custom exception
            $exceptions->render(static fn (ApiMonitoringException $e, $request) => $e->render());

            $exceptions->report(static function (ApiMonitoringException $e): void {
                $e->report();
            });

            $exceptions->dontReportDuplicates();
        },
    )
    ->create();
