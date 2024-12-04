<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Repositories\LoginActivity\LoginActivityRepositoryInterface;
use App\Repositories\LoginActivity\LoginActivityRepository;
use Illuminate\Support\ServiceProvider;

final class RepositoriesBindingProvider extends ServiceProvider
{
    public function register(): void
    {
        $bindings = [
            \App\Contracts\Repositories\Country\CountryRepositoryInterface::class => \App\Repositories\Country\CountryRepository::class,
            \App\Contracts\Repositories\Country\CountryTranslationRepositoryInterface::class => \App\Repositories\Country\CountryTranslationRepository::class,
            \App\Contracts\Repositories\Currency\CurrencyRepositoryInterface::class => \App\Repositories\Currency\CurrencyRepository::class,
            \App\Contracts\Repositories\Currency\CurrencyTranslationRepositoryInterface::class => \App\Repositories\Currency\CurrencyTranslationRepository::class,
            LoginActivityRepositoryInterface::class => LoginActivityRepository::class,
        ];

        foreach ($bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
