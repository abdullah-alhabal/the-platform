<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Country;
use App\Observers\CountryObserver;
use Illuminate\Support\ServiceProvider;

final class ObserverServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Country::observe(CountryObserver::class);
    }
}
