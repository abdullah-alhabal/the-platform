<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        Gate::define('viewPulse', fn (User $user) => $user->isAdmin());

        RateLimiter::for('api', fn (Request $request) => \Illuminate\Cache\RateLimiting\Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip()));

        Sanctum::usePersonalAccessTokenModel(
            model: PersonalAccessToken::class,
        );

        ResetPassword::createUrlUsing(
            callback: static fn (object $notifiable, string $token) => config('app.frontend_url') . "/password-reset/{$token}?email={$notifiable->getEmailForPasswordReset()}",
        );

        Gate::before(fn ($user, $ability) => $user->hasRole('Super Admin') ? true : null);
    }
}
