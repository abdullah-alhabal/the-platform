<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\ExceptionServiceProvider::class,
    App\Providers\ObserverServiceProvider::class,
    App\Providers\RepositoriesBindingProvider::class,
    App\Providers\ServiceBindingProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
];
